<?php

// 初期処理
require_once(__DIR__ . "/../Libs/init.php");

//
if (isset($_SESSION["register"])) {
    $register = $_SESSION["register"];
    unset($_SESSION["register"]);
} else {
    $register = [];
}

//
$template_file_name = "register.twig";
$template_data = ["register" => $register];

// 終了処理
require_once(BASEPATH . "/Libs/fin.php");
