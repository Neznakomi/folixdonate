<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

session_start();
include 'Main.class.php';
class Admin
{

	public function __construct()
	{
		$this->engine = new Engine;
		$this->events();
	}

	public function events() {
		if($this->auth()) {
			if(isset($_POST['add_server'])) $this->server_action("new", $_POST);
			if(isset($_POST['edit_server'])) $this->server_action("edit", $_POST);

			if(isset($_POST['add_group'])) $this->group_action("new", $_POST);
			if(isset($_POST['edit_group'])) $this->group_action("edit", $_POST);

			if(isset($_POST['add_promo'])) $this->promo_action("new", $_POST);
			if(isset($_POST['edit_promo'])) $this->promo_action("edit", $_POST);

			if(isset($_POST['add_category'])) $this->category_action("new", $_POST);
			if(isset($_POST['edit_category'])) $this->category_action("edit", $_POST);

			if(isset($_GET['logout'])) { session_unset(); session_destroy(); }
		}
	}

	public function send_auth($user) {
		if($this->auth) return $this->engine->add_message('Вы уже авторизованы.', true);
		if(in_array($user['uid'], $this->engine->cfg['admin']['access'])) {
			$_SESSION['uid'] = $user['uid'];
			$_SESSION['first_name'] = $user['first_name'];
			$_SESSION['last_name'] = $user['last_name'];
			$this->engine->add_message('Вы авторизовались.');
			$this->engine->redirect("/admin/");
		} else {
			$this->engine->add_message('У вас нет доступа.', true);
		}
	}

	public function auth() {
		if(in_array($_SESSION['uid'], $this->engine->cfg['admin']['access']) && $_SESSION['first_name'] && $_SESSION['last_name']) return true;
		return false;
	}

	public function alert($text, $action){
		return '<div class="alert alert-dismissible alert-' . $action . '">
				  ' . $text . '
				</div>';
	}

	###СТАТИСТИКА###
	public function statistics() {
		$query = $this->engine->query("SELECT * FROM `orders` WHERE `date` = '".date("Y-m-d")."'");
		$array = array("profit" => 0, "buyers" => 0, "wait" => 0);
		while($pr = $query->fetch_object()) {
			if($pr->status == 1) {
				$array['profit'] += $pr->profit;
				$array['buyers'] += 1;
			} elseif($pr->status == 0) {
				$array['wait'] += 1;
			}
		}

		return array(
			"orders" => $query->num_rows,
			"profit" => $array['profit'],
			"buyers" => $array['buyers'],
			"wait" => $array['wait']
		);
	}

	###ДОНАТЕРЫ###
	public function donaters() {
		return $this->engine->query("SELECT * FROM `orders` WHERE `status` = 1 ORDER BY `orders`.`date` DESC");
	}

	###СЕРВЕРА###
	public function servers() {
		return $this->engine->query("SELECT * FROM `servers`");
	}

	###ПРОМО-КОДЫ###
	public function promos() {
		return $this->engine->query("SELECT * FROM `promo`");
	}


	public function server($id) {
		$query = $this->engine->query_result("SELECT * FROM `servers` WHERE `id` = '".(int)$id."'");
		if(!$query) return false;
		return array(
			"id" => $query->id,
			"ip" => $query->ip,
			"port" => $query->port,
			"pass" => $query->pass,
			"name" => $query->name
		);
	}

	public function promo($id) {
		$query = $this->engine->query_result("SELECT * FROM `promo` WHERE `id` = '".(int)$id."'");
		if(!$query) return false;
		return array(
			"id" => $query->id,
			"name" => $query->name,
			"disc" => $query->disc
		);
	}

	public function server_action($type, $post='', $id='') {
	if(!$this->auth()) return $this->engine->add_message("Вы не авторизованы.", true);

	if($type == "new" || $type == "edit") {
		if(!$post['name'] || !$post['ip'] || !$post['port'] || !$post['pass']) return $this->engine->add_message("Необходимо заполнить все поля.", true);
		if($type == "new") {
			$this->engine->query("INSERT INTO `servers`(`ip`, `port`, `pass`, `name`) VALUES ('{$this->engine->escape($post['ip'])}', '{$this->engine->escape($post['port'])}', '{$this->engine->escape($post['pass'])}', '{$this->engine->escape($post['name'])}')");
			return $this->engine->add_message("Сервер был добавлен.");
		}
		elseif($type == "edit") {
			if(!$this->server($post['id'])) return $this->engine->add_message("Сервер не обнаружен.", true);
			$this->engine->query("UPDATE `servers` SET `ip`='{$this->engine->escape($post['ip'])}',`port`='{$this->engine->escape($post['port'])}',`pass`='{$this->engine->escape($post['pass'])}',`name`='{$this->engine->escape($post['name'])}' WHERE id = '".(int)$post['id']."'");
			return $this->engine->add_message("Сервер был обновлен.");
		}
	}
	elseif($type == "remove") {
		$this->engine->query("DELETE FROM `servers` WHERE `id` = '".(int)$id."'");
		return $this->engine->add_message("Сервер был удален.");
	}
}

	public function promo_action($type, $post='', $id='') {
		if(!$this->auth()) return $this->engine->add_message("Вы не авторизованы.", true);

		if($type == "new" || $type == "edit") {
			if(!$post['name'] || !$post['disc']) return $this->engine->add_message("Необходимо заполнить все поля.", true);
			if($type == "new") {
				$this->engine->query("INSERT INTO `promo` (`name`, `disc`) VALUES ('{$this->engine->escape($post['name'])}', '{$this->engine->escape($post['disc'])}')");
				return $this->engine->add_message("Код был добавлен.");
			}
			elseif($type == "edit") {
				if(!$this->server($post['id'])) return $this->engine->add_message("Код не обнаружен.", true);
				$this->engine->query("UPDATE `promo` SET `name`='{$this->engine->escape($post['name'])}', `disc`='{$this->engine->escape($post['disc'])}'");
				return $this->engine->add_message("Код был обновлен.");
			}
		}
		elseif($type == "remove") {
			$this->engine->query("DELETE FROM `promo` WHERE `id` = '".(int)$id."'");
			return $this->engine->add_message("Код был удален.");
		}
	}

	###ГРУППЫ###
	public function groups() {
		return $this->engine->query("SELECT * FROM `groups`");
	}

	public function group($id) {
		$query = $this->engine->query_result("SELECT * FROM `groups` WHERE `id` = '".(int)$id."'");
		if(!$query) return false;
		return array(
			"id" => $query->id,
			"name" => $query->name,
			"price" => $query->price,
			"cmd" => $query->cmd,
			"category" => $query->category,
			"surcharge" => $query->surcharge,
			"color" => $query->color,
			"info" => $query->info
		);
	}

	/* public function group_action($type, $post='', $id='') {
		if(!$this->auth()) return $this->engine->add_message("Вы не авторизованы.", true);

		if($type == "new" || $type == "edit") {
			if(!$post['name'] || !$post['price'] || !$post['cmd'] || !$post['category']) return $this->engine->add_message("Необходимо заполнить все поля.", true);
			if($post['surcharge'] != 1 && $post['surcharge'] != 0) return $this->engine->add_message("Доплата указана не верно.", true);
			if($type == "new") {
				$this->engine->query("INSERT INTO `groups`(`name`, `price`, `cmd`, `category`, `surcharge`, `color`, `info`) VALUES ('{$this->engine->escape($post['name'])}', '{$this->engine->escape($post['price'])}', '{$this->engine->escape($post['cmd'])}', '{$this->engine->escape($post['category'])}', '{$this->engine->escape($post['surcharge'])}', '{$this->engine->escape($post['color'])}', '{$this->engine->escape($post['info'])}')");
				return $this->engine->add_message("Товар был добавлен.");
			}
			elseif($type == "edit") {
				if(!$this->group($post['id'])) return $this->engine->add_message("Товар не обнаружен.", true);
				$this->engine->query("UPDATE `groups` SET `name`='{$this->engine->escape($post['name'])}',`price`='{$this->engine->escape($post['price'])}',`cmd`='{$this->engine->escape($post['cmd'])}',`category`='{$this->engine->escape($post['category'])}','`surcharge`='{$this->engine->escape($post['surcharge'])}', `color`='{$this->engine->escape($post['color'])}', `info`='{$this->engine->escape($post['info'])} WHERE id = '".(int)$post['id']."'");
				return $this->engine->add_message("Товар был обновлен.");
			}
		}
		elseif($type == "remove") {
			$this->engine->query("DELETE FROM `groups` WHERE `id` = '".(int)$id."'");
			return $this->engine->add_message("Товар был удален.");
		}
	}*/

	public function group_action($type, $post='', $id='') {
		if(!$this->auth()) return $this->engine->add_message("Вы не авторизованы.", true);

		if($type == "new" || $type == "edit") {
			if(!$post['name'] || !$post['price'] || !$post['cmd'] || !$post['category'] || !$post['color'] || !$post['info']) return $this->engine->add_message("Необходимо заполнить все поля.", true);
			if($post['surcharge'] != 1 && $post['surcharge'] != 0) return $this->engine->add_message("Доплата указана не верно.", true);
			if($type == "new") {
				$this->engine->query("INSERT INTO `groups`(`name`, `price`, `cmd`, `category`, `surcharge`, `color`, `info`) 
            VALUES (
            '{$this->engine->escape($post['name'])}', 
            '{$this->engine->escape($post['price'])}', 
            '{$this->engine->escape($post['cmd'])}', 
            '{$this->engine->escape($post['category'])}', 
            '{$this->engine->escape($post['surcharge'])}', 
            '{$this->engine->escape($post['color'])}',
            '{$this->engine->escape($post['info'])}')");
				return $this->engine->add_message("Товар был добавлен.");
			}
			elseif($type == "edit") {
				if(!$this->group($post['id'])) return $this->engine->add_message("Товар не обнаружен.", true);
				$this->engine->query("UPDATE `groups` SET 
                  `name`='{$this->engine->escape($post['name'])}',
                  `price`='{$this->engine->escape($post['price'])}',
                  `cmd`='{$this->engine->escape($post['cmd'])}',
                  `category`='{$this->engine->escape($post['category'])}',
                  `surcharge`='{$this->engine->escape($post['surcharge'])}',
                  `color`='{$this->engine->escape($post['color'])}',
                  `info`='{$this->engine->escape($post['info'])}' WHERE id = '".(int)$post['id']."'");
				return $this->engine->add_message("Товар был обновлен.");
			}
		}
		elseif($type == "remove") {
			$this->engine->query("DELETE FROM `groups` WHERE `id` = '".(int)$id."'");
			return $this->engine->add_message("Товар был удален.");
		}
	}

	public function categoris() {
		//SELECT * FROM `groups` ORDER BY `id` ASC
		$groups = $this->engine->query("SELECT * FROM `categories`");
		$list = array();
		while ($el = mysqli_fetch_assoc($groups)) {
			if (!is_array($list[$el['category']])) $list[$el['category']] = array();
			$list[$el['category']][] = $el;
		}
		$form = '';
		foreach ($list as $cat => $group) {
			$form .= '<option value="'. $cat .'" label="' . $cat . '">';
			$form .= '</optgroup>';
		}
		return $form;
	}

	public function categories() {

		return $this->engine->query("SELECT * FROM `categories`");
	}

	public function category($id) {
		$query = $this->engine->query_result("SELECT * FROM `categories` WHERE `id` = '".(int)$id."'");
		if(!$query) return false;
		return array(
			"id" => $query->id,
			"category" => $query->category,
		);
	}

	public function category_action($type, $post='', $id='') {
		if(!$this->auth()) return $this->engine->add_message("Вы не авторизованы.", true);

		if($type == "new" || $type == "edit") {
			if(!$post['name']) return $this->engine->add_message("Необходимо заполнить все поля.", true);
			if($type == "new") {
				$this->engine->query("INSERT INTO `categories` (`category`) VALUES ('{$this->engine->escape($post['name'])}')");
				return $this->engine->add_message("Код был добавлен.");
			}
			elseif($type == "edit") {
				if(!$this->server($post['id'])) return $this->engine->add_message("Код не обнаружен.", true);
				$this->engine->query("UPDATE `categories` SET `category`='{$this->engine->escape($post['name'])}' WHERE id = '".(int)$post['id']."'");
				return $this->engine->add_message("Код был обновлен.");
			}
		}
		elseif($type == "remove") {
			$this->engine->query("DELETE FROM `categories` WHERE `id` = '".(int)$id."'");
			return $this->engine->add_message("Код был удален.");
		}
	}

    public function rconlog() {
		$log = $this->engine->query("SELECT * FROM `log`");
		return $log;
    }

}
?>
