<?php
require_once('libs/smarty/Smarty.class.php');
include('engine/classes/Main.class.php');

$engine = new Engine();
$smarty = new Smarty;

$smarty->debugging = false;
$smarty->caching = false;
$smarty->setTemplateDir($_SERVER['DOCUMENT_ROOT'].'/templates/');

$smarty->assign('messages_list', $engine->messages);
$smarty->assign('groups', $engine->groups());
$smarty->assign('cfg', $engine->cfg);

$smarty->display('main.php');
