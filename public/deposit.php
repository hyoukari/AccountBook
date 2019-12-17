<?php
// 初期処理 + 認可チェック
require_once(__DIR__ . "/../Libs/init_auth.php");
// 
require_once(BASEPATH . "/Model/AccountBookModel.php");

// 多少のvalidate
$amount = (int) ($_POST["amount"] ?? 0);
if (0 >= $amount) {
    // XXX
    echo "有効な金額を入れろ";
    exit;
}
// var_dump($amount);

// 入金(insert)
$obj = new AccountBookModel();
$obj->deposit_amount = $amount;
$obj->user_id = $_SESSION["auth"]["user_id"];
// var_dump($obj);
// exit;
$r = $obj->insert();
// var_dump($r);

// 「入金しました」表示用ギミック
$_SESSION["flash"]["deposit_success"] = true;

// TopにLocation
header("Location: ./top.php");
