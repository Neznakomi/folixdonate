<?php

/*
 * Скрипт авто-доната Майнкрафт
 * by RoseStudio
 * vk.com/unfixxx | vk.com/rosestudio_mc
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/engine/classes/Main.class.php';

$Engine = new Engine;

if (isset($_REQUEST['method']) && isset($_REQUEST['params'])) {
    unset($_SESSION);
    echo $Engine->payment_action(strtolower($_REQUEST['method']), $_REQUEST['params']);
    exit();
}