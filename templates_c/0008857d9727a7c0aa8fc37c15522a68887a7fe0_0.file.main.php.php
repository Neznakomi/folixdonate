<?php
/* Smarty version 3.1.30, created on 2020-04-10 01:17:11
  from "/var/www/user50598/data/www/moonpixel.ru/templates/main.php" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5e8f9ee78fb060_62652047',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0008857d9727a7c0aa8fc37c15522a68887a7fe0' => 
    array (
      0 => '/var/www/user50598/data/www/moonpixel.ru/templates/main.php',
      1 => 1586470606,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:messages.html' => 1,
  ),
),false)) {
function content_5e8f9ee78fb060_62652047 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!---

    ____  ____ _____ ___________________  ______  ________
   / __ \/ __ / ___// ____/ ___/_  __/ / / / __ \/  _/ __ \
  / /_/ / / / \__ \/ __/  \__ \ / / / / / / / / // // / / /
 / _, _/ /_/ ___/ / /___ ___/ // / / /_/ / /_/ _/ // /_/ /
/_/ |_|\____/____/_____//____//_/  \____/_____/___/\____/

                   ROSESTUDIO - 2020

-->

<html>
<head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <title><?php echo $_smarty_tpl->tpl_vars['cfg']->value['server']['name'];?>
 :: Покупка доната</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <?php echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"><?php echo '</script'; ?>
>
    <link rel="stylesheet" type="text/css" href="/templates/styles/style/fonts.css">
    <link rel="stylesheet" type="text/css" href="/templates/styles/style/style.css">
    <link rel="shortcut icon" href="templates/styles/img/favicon.png" type="image/png">
	<meta name="keywords" content="ROSESTUDIO">
    <?php echo '<script'; ?>
 src="https://use.fontawesome.com/2c3ba6a7cb.js"><?php echo '</script'; ?>
>
</head>

<body>
<?php echo '<script'; ?>
>
    function openbox(id){
        display = document.getElementById(id).style.display;

        if(display=='none'){
            document.getElementById(id).style.display='block';
        }else{
            document.getElementById(id).style.display='none';
        }
    }
    function closebox(id){
        display = document.getElementById(id).style.display;

        if(display!='none'){
            document.getElementById(id).style.display='none';
        }else{
            document.getElementById(id).style.display='block';
        }
    }
<?php echo '</script'; ?>
>

  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Правила</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <?php echo $_smarty_tpl->tpl_vars['cfg']->value['rules']['rule'];?>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
        </div>
      </div>
    </div>
  </div>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-transparent">
        <a class="navbar-brand vblack text-uppercase" href="#"><?php echo $_smarty_tpl->tpl_vars['cfg']->value['server']['name'];?>
</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor03">
                <a class="rules" data-toggle="modal" data-target="#myModal" href="/#rules">ПРАВИЛА</a>
                <a class="don" data-toggle="modal" data-target="#donat" href="/#donaters">Последние донаты</a>
        </div>
    </nav>
        <div class="container pt-lg-5">
            <?php $_smarty_tpl->_subTemplateRender("file:messages.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                <div class="pt-4 mx-auto">
                    <div class="card border-light mb-3" style="max-width: 70rem;">
                        <div class="card-header"><?php echo $_smarty_tpl->tpl_vars['cfg']->value['alert']['header'];?>
</div>
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $_smarty_tpl->tpl_vars['cfg']->value['alert']['title'];?>
</h4>
                            <p class="card-text"><?php echo $_smarty_tpl->tpl_vars['cfg']->value['alert']['text'];?>
</p>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-6">
                        <div class="shadow bg-white rounded p-4 infod text-center">
                            <a><div class="text-left" id="online"></div></a>
                            <br>
                            <form action="/" method="post" id="rosestudio">
                                <p class="text-left">Введите никнейм</p>
                                <input class="form-control" type="text" name="nick" id="nick" placeholder="Введите ник">
                                <br>
                                <p class="text-left">Выберите товар</p>
                                <select class="form-control" id="group" name="group">
                                    <?php echo $_smarty_tpl->tpl_vars['groups']->value;?>

                                </select>
                                <br>
                                <div id="nahui" style="margin-bottom: 7px;">
                                    <a href="#" style="color: #000000;" onclick="openbox('huyak'); closebox('nahui'); return false">У меня есть промокод..<br></a>
                                </div>

                                <div id="huyak" class="form-group" style="display: none;">
                                    <p class="text-left">Промо-код</p>
                                    <input type="text" class="form-control" id="promo" name="promo" placeholder="Введите промокод, если он у вас есть">
                                </div>
                                <button type="submit" name="buy" id="buy" class="btn btn-buy">ВЫБЕРЕТЕ ТОВАР</button>
								<div id="promobuy"></div>
                            </form>
                        </div>
                   </div>
                    <div class="col-6">
                        <div class="shadow bg-white rounded p-4 infof">
                            <div class="info-anim" id="info">
							<?php echo $_smarty_tpl->tpl_vars['cfg']->value['info']['title'];?>

                            <?php echo $_smarty_tpl->tpl_vars['cfg']->value['info']['description'];?>

                            </div>
                        </div>
                    </div>
                    </div>
                 </div>
             </div>
           </div>
         </div>

         <div id="test"></div>


  <div class="outlinks">
      <ul class="m-0">
          <li>
              <a class="item" href="<?php echo $_smarty_tpl->tpl_vars['cfg']->value['server']['vk-link'];?>
" target="_blank">
                  <div class="icon-block"><i class="fa fa-vk"></i></div>
                  <div class="text-block vblack">ВКонтакте</div>
              </a>
          </li>
      </ul>
  </div>
        <br>
  <div>
  <div class="footer text-right">
      <span class="dev">Разработано - <a class="extra_color" href="https://vk.com/rosestudio_mc" style="text-decoration: none;" target="_blank">RoseStudio</a></span>
  </div>
  </div>
       <?php echo '<script'; ?>
 src="https://code.jquery.com/jquery-1.11.3.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
>
			$.post('/engine/ajax.php?type=online', {}, function(data) {
            $('#online').html(data);
            });
            $.post('/engine/ajax.php?type=donaters', {}, function(data) {
                $('#donaters').html(data);
            });
            var timer_key;
            $('#rosestudio input, #rosestudio select, #rosestudio textarea').on('keydown change', function() {
                clearTimeout(timer_key);
                timer_key = setTimeout(function() {
                    $.get('/engine/ajax.php', {
                        type: 'view',
                        nick: $('#nick').val(),
                        group: $('#group option:selected').val(),
                        promo: $('#promo').val()
                    }, function(text) {
                        var str = text
                        var matches = str.split('|')
                        $('#buy').text(matches[1]);
                        $('#info').html(matches[2]);
                    });
                }, 100);
            });
        <?php echo '</script'; ?>
>
  <div class="modal fade" id="donat" role="dialog">
      <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title">Последние донатеры:</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                  <div class="donat" id="donaters"></div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                  </div>
              </div>
          </div>
      </div>
</body>
</html><?php }
}
