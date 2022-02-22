<?php
require_once('minestat.php');

$ms = new MineStat("proxmc.ru", 25565);
if($ms->is_online())
{
  printf("ТЕКУЩИЙ ОНЛАЙН: %s", $ms->get_current_players());
}
else
{
  printf("Сервер не работает<br>");
}
?>