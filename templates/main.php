<meta name="verification" content="7270b05cd64d6ec32f42428b488cee" />
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
    <title>{$cfg['server']['name']} :: Покупка доната</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="/templates/styles/style/fonts.css">
    <link rel="stylesheet" type="text/css" href="/templates/styles/style/style.css">
    <link rel="shortcut icon" href="templates/styles/img/favicon.png" type="image/png">
	<meta name="keywords" content="ROSESTUDIO, ProxMine">
    <script src="https://use.fontawesome.com/2c3ba6a7cb.js"></script>
</head>

<body>
<script>
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
</script>

  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Правила</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          {$cfg['rules']['rule']}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
        </div>
      </div>
    </div>
  </div>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-transparent">
        <a class="navbar-brand vblack text-uppercase" href="#">{$cfg['server']['name']}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor03">
                <a class="rules" data-toggle="modal" data-target="#myModal" href="/#rules">ПРАВИЛА</a>
                <a class="don" data-toggle="modal" data-target="#donat" href="/#donaters">Последние донаты</a>
        </div>
    </nav>
        <div class="container pt-lg-5">
            {include file='messages.html'}
                <div class="pt-4 mx-auto">
                    <div class="card border-light mb-3" style="max-width: 70rem;">
                        <div class="card-header">{$cfg['alert']['header']}</div>
                        <div class="card-body">
                            <h4 class="card-title">{$cfg['alert']['title']}</h4>
                            <p class="card-text">{$cfg['alert']['text']}</p>
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
                                    {$groups}
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
                            </form>
                        </div>
                   </div>
                    <div class="col-6">
                        <div class="shadow bg-white rounded p-4 infof">
                            <div class="info-anim" id="info">
                            {$cfg['info']['description']}
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
              <a class="item" href="{$cfg['server']['vk-link']}" target="_blank">
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
       <script src="https://code.jquery.com/jquery-1.11.3.js"></script>
        <script>
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
        </script>
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
</html>