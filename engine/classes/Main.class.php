<?php
/*
 * Скрипт авто-доната Майнкрафт
 * by RoseStudio
 * vk.com/unfixxx | vk.com/rosestudio_mc
 */
date_default_timezone_set('Europe/Moscow');
class Engine
{

    public $db;
    public $cfg;
    public $messages = array();


    public function __construct()
    {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/engine/config.php');
        $this->cfg = $config;
        $this->db = new mysqli($config['db']['db_host'], $config['db']['db_user'], $config['db']['db_pass'], $config['db']['db_name']);
        if ($this->db->connect_error) {
            die("Couldn't connect to MySQLi: " . $this->db->connect_error);
        }
        if (!$this->db->set_charset("utf8")) {
            die("Ошибка при загрузке набора символов utf8: " . $this->db->error);
        }
        $this->events();
    }

    public function events()
    {
        if (isset($_POST['buy'])) {
            $buy = explode("|", $this->buy_price($_POST['nick'], $_POST['group'], $_POST['promo'], "buy"));
            if ($buy[0] == "error") return $this->add_message($buy[3], true);
            return $this->add_message('Переходим к оплате...!');

        }
        if (isset($_REQUEST['success'])) $this->add_message('Вы успешно купили привилегию!');
        if (isset($_REQUEST['error'])) $this->add_message('Во время покупки привилегии произошла ошибка!', true);

    }

    public function add_message($text, $err = false)
    {
        $this->messages[] = array('text' => $text, 'err' => $err);
    }

    public function query($query)
    {
        return $this->db->query($query);
    }

    public function query_result($query)
    {
        return $this->db->query($query)->fetch_object();
    }

    public function escape($str)
    {
        return $this->db->real_escape_string($str);
    }

    public function redirect($url)
    {
        echo '<script type="text/javascript">';
        echo 'window.location.href="' . $url . '";';
        echo '</script>';
    }

    public function groups()
    {
        //SELECT * FROM `groups` ORDER BY `id` ASC
        $groups = $this->query("SELECT * FROM `groups` ORDER BY `groups`.`price` ASC");
        $list = array();
        while ($el = mysqli_fetch_assoc($groups)) {
            if (!is_array($list[$el['category']])) $list[$el['category']] = array();
            $list[$el['category']][] = $el;
        }
        $form = '<option selected disabled>Выберите услугу</option>';
        foreach ($list as $cat => $group) {
            $form .= '<optgroup label="' . $cat . '">';
            foreach ($group as $data) {
                $form .= '<option value="' . $data['id'] . '" style="background-color: ' . $data['color'] . ';">' . $data['name'] . ' - ' . $data['price'] . ' Р.</option>';
            }
            $form .= '</optgroup>';
        }
        return $form;
    }

    public function group($id)
    {
        $query = $this->query_result("SELECT * FROM `groups` WHERE `id` = " . (int)$id . " LIMIT 1");
        if ($query == null) return false;
        return $query;
    }

    public function order($id)
    {
        $query = $this->query_result("SELECT * FROM orders WHERE id = '" . intval($id) . "' LIMIT 1");
        if ($query == null) return false;
        return $query;
    }

    public function rcon_log($login, $cmd)
    {
        $this->query("INSERT INTO `log` (`nick`, `message`) VALUES ('" . $login . "', '" . $cmd . "')");
    }

    public function promo($promo, $price)
    {
        $promo = $this->query_result("SELECT * FROM `promo` WHERE name = '{$promo}' LIMIT 1");
        if (!$promo) return $price;
        return $price - ($price * $promo->disc/100);
    }


    public function surcharge($nick, $type = 'get', $price = '')
    {
        if ($type == "get") {
            $replay = $this->query_result("SELECT * FROM `surcharge` WHERE nick = '" . $nick . "' ORDER BY id DESC LIMIT 1");
            if ($replay == null) return false;
            return $replay;
        } elseif ($type == "add") $this->query("INSERT INTO `surcharge` (`nick`, `price`) VALUES ('" . $nick . "', '" . $price . "')");
    }

    public function buy_price($nick, $group, $promo, $type = 'check')
    {
        $nick = $this->escape(trim(strip_tags($nick)));
        $group = $this->escape(trim(strip_tags($group)));

        //if (empty($nick)) return "error|Ник не указан|". $this->alert($this->cfg['info']['description']);

        //if (empty($group)) return "error|Купить/Доплатить|" . $this->alert($this->cfg['info']['description']);
        // $group = $this->group($group);
        // if (!$group) return "error|Купить/Доплатить|" . $this->alert($this->cfg['info']['description']);

        if(empty($nick)) return "error|Ник не указан||";
        if(empty($group)) return "error|Купить / Доплатить|". $this->alert("".$this->cfg['info']['description']. "", "".$this->cfg['info']['title']. "");
        $group = $this->group($group);
        if(!$group) return "error|Купить / Доплатить|". $this->alert("".$this->cfg['info']['description'] . "", $this->cfg['info']['title']. "");

        $price = $group->price;
        $surcharge = $this->surcharge($nick);

        if ($group->surcharge == 1) {
            if ($surcharge != NULL) {
                $price = $price - $surcharge->price;
            }
        }
        if (!empty($promo)) $price = $this->promo($this->escape(trim(strip_tags($promo))), $price);

        if ($price > 0) {
            if ($type == "check") {
                if ($surcharge == NULL || $group->surcharge == 0) {
                    $info = mysqli_fetch_assoc($this->query("SELECT `info` FROM `groups` WHERE `name`= '$group->name' LIMIT 1;"));
                    return "ok|Купить " . $price . " Р.|" . $this->alert("" . $info["info"], "" . $group->name . "");
                } else
                    $info = mysqli_fetch_assoc($this->query("SELECT `info` FROM `groups` WHERE `name`= '$group->name' LIMIT 1;"));
                return "ok|Доплатить " . $price . " Р.|" . $this->alert("" . $info["info"], "" . $group->name . "");
            } else if ($type == "buy") {
                $this->buy($nick, $price, $group->id);
            } else return false;
        } else
            return "error|У вас имеется более высокий донат!|" . $this->alert("У вас уже имеется более высокий донат, выберите другой из списка!", "Ошибка") . "|У вас имеется более высокий донат!";
    }

    public function buy($nick, $price, $group)
    {
        $date = date("Y-m-d");
        $time = date("G:i:s");
        $month = date("n");
        $group = $this->group($group);
        $this->query("INSERT INTO `orders`(`groupid`, `group`, `price`, `nick`, `date`, `time`, `month`) VALUES ('" . $group->id . "','" . $group->name . "','" . $price . "','" . $nick . "', '" . $date . "', '" . $time . "', '" . $month . "')");

        $desc = "Покупка игрового товара '" . $group->name . "' для игрока " . $nick . " (" . $this->cfg["server"]["name"] . ")";
        $this->redirect("https://unitpay.ru/pay/{$this->cfg['unitpay']['project_id']}/qiwi?sum={$price}&account={$this->db->insert_id}*{$nick}&desc={$desc}&signature={$this->getFormSignature($this->db->insert_id .'*'.$nick, $desc, $price, $this->cfg['unitpay']['key'])}");
    }


    function getFormSignature($account, $desc, $sum, $secretKey)
    {
        $hashStr = $account . '{up}' . $desc . '{up}' . $sum . '{up}' . $secretKey;
        return hash('sha256', $hashStr);
    }

    public function payment_replay($params, $message, $type = "error")
    {
        if ($type == "success") {
            return json_encode(
                array(
                    "jsonrpc" => "2.0",
                    "result" => array(
                        "message" => $message
                    ),
                    'id' => $params['projectId']
                )
            );
        } else {
            return json_encode(
                array(
                    "jsonrpc" => "2.0",
                    "error" => array(
                        "code" => -32000,
                        "message" => $message
                    ),
                    'id' => $params['projectId']
                )
            );
        }
    }

    private function get_sign($method, array $params)
    {
        $delimiter = '{up}';
        ksort($params);
        unset($params['sign']);
        unset($params['signature']);

        return hash('sha256', $method . $delimiter . join($delimiter, $params) . $delimiter . $this->cfg['unitpay']['key']);
    }

    public function payment_action($method, $params)
    {
        if ($params['signature'] != $this->get_sign($method, $params)) return $this->payment_replay($params, "Подпись не верна");
        $account = explode("*", $params['account']);
        $data = $this->order((int)$account[0]);
        $group = $this->group($data->groupid);
        if (!$data) return $this->payment_replay($params, "Счет не обнаружен");
        if ($method == 'check') {
            return $this->payment_replay($params, "Счет готов к оплате", "success");
        } elseif ($method == 'pay') {
            if ($data->status == 1) return $this->payment_replay($params, "Счет уже оплачен");
            $this->query("UPDATE `orders` SET `status` = '1', `profit` = '" . $params['profit'] . "' WHERE `id` = " . (int)$data->id);
            if ($group->surcharge == 1) $this->surcharge($data->nick, "add", $data->price);
            $this->payment_rcon($data->id);
            return $this->payment_replay($params, "Счет успешно оплачен, выдаем донат...", "success");
        } else return $this->payment_replay($params, "Метод не поддерживается: " . $method);
    }

    public function payment_rcon($order)
    {
        $data = $this->order($order);
        $group = $this->group($data->groupid);
        $arr = array("&lowbar;" => "_", " " => "");
        $nick = strtr($data->nick, $arr);
        require_once($_SERVER['DOCUMENT_ROOT'] . '/engine/classes/Rcon.class.php');
        $servers = $this->query("SELECT * FROM `servers`");
        while ($s = $servers->fetch_object()) {
            $rcon = new Rcon($s->ip, $s->port, $s->pass, 5);
            foreach (explode(';', $group->cmd) as $c) {
                $cmd = str_replace(array('[nick]'), array($nick), $c);
                if (@$rcon->connect()) {
                    $rcon->send_command($cmd);
                    $this->rcon_log($nick, "CONNECT: " . $rcon->get_response());
                } else $this->rcon_log($nick, "ERROR: " . $rcon->get_response());
            }
        }
    }

    public function date($date)
    {
        $time = explode(" ", $date);
        $month = explode("-", $time[0]);
        if ($month[1] == 1) $month_t = "января";
        elseif ($month[1] == 2) $month_t = "Февраля";
        elseif ($month[1] == 3) $month_t = "марта";
        elseif ($month[1] == 4) $month_t = "апреля";
        elseif ($month[1] == 5) $month_t = "мая";
        elseif ($month[1] == 6) $month_t = "июня";
        elseif ($month[1] == 7) $month_t = "июля";
        elseif ($month[1] == 8) $month_t = "августа";
        elseif ($month[1] == 9) $month_t = "сентября";
        elseif ($month[1] == 10) $month_t = "октября";
        elseif ($month[1] == 11) $month_t = "ноября";
        elseif ($month[1] == 12) $month_t = "декабря";
        else return $date;
        $sec = explode(":", $time[1]);
        if ($time[0] == date("Y-m-d")) return "Сегодня в " . $sec[0] . ":" . $sec[1];
        elseif ($time[0] == date('Y-m-d', strtotime('-1 days'))) return "Вчера в " . $sec[0] . ":" . $sec[1];
        else return $month[2] . " " . $month_t . " в " . $sec[0] . ":" . $sec[1];
    }

    public function alert($text, $action)
    {

        return '<h1 class="text-center">' . $action . '</h1><br><h6>' . $text . '</h6>';

    }

}
?>