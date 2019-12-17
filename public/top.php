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

// 対象年月を把握
if (isset($_GET["y"]) && isset($_GET["m"])) {
    $y = $_GET["y"];
    $m = $_GET["m"];
} else {
    list($y, $m) = explode("-", date("Y-m")); // 現在年月
}


// 「前月」よ「翌月」を把握
$m = (int) $m;
$y = (int) $y;
if (1 === $m) {
    $template_data["before_m"] = 12;
    $template_data["before_y"] = $y - 1;
} else {
    $template_data["before_m"] = $m - 1;
    $template_data["before_y"] = $y;
}
if (12 === $m) {
    $template_data["after_m"] = 1;
    $template_data["after_y"] = $y + 1;
} else {
    $template_data["after_m"] = $m + 1;
    $template_data["after_y"] = $y;
}


// 出納帳の一覧を取得
$list = AccountBookModel::getList($y, $m);
// var_dump($list);
$template_data["list"] = $list;

// 終了処理
require_once(BASEPATH . "/Libs/fin.php");
