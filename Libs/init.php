<?php
/*
 * 初期処理
 */

// セッションの開始
ob_start();
session_start();


//
define("BASEPATH", realpath(__DIR__ . "/../"));
//
require_once(BASEPATH . "/vendor/autoload.php");
require_once(BASEPATH . "/Libs/Config.php");
$conf = Config::getAll();
require_once(BASEPATH . "/Libs/DB.php");
// var_dump($conf);

$dir = $conf["view_front"]["template_dir"];
$loader = new  \Twig\Loader\FilesystemLoader($dir);
$twig = new \Twig\Environment($loader);
// var_dump($twig);
