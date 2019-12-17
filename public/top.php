<?php
// 初期処理
require_once(__DIR__ . "/../Libs/init_auth.php");
require_once(BASEPATH . "/Model/AccountBookModel.php");
//
$template_file_name = "top.twig";
$template_data = [];

//
if (true === isset($_SESSION["flash"])) {
    $template_data += $_SESSION["flash"];
    unset($_SESSION["flash"]);
}

// 出納帳の一覧を取得
$list = AccountBookModel::getList();
// var_dump($list);
$template_data["list"] = $list;

// 終了処理
require_once(BASEPATH . "/Libs/fin.php");
