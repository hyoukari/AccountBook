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
$account_title = (string) ($_POST["account_title"] ?? "");
if ("" === $account_title) {
    // XXX
    echo "有効な科目を入れろ";
    exit;
}
// var_dump($amount);

// 出金(insert)
$obj = new AccountBookModel();
$obj->withdrawal_amount = $amount;
$obj->withdrawal_account_title = $account_title;
$obj->user_id = $_SESSION["auth"]["user_id"];
// var_dump($obj);
// exit;
$r = $obj->insert();
// var_dump($r);

// 「入金しました」表示用ギミック
$_SESSION["flash"]["withdrawal_success"] = true;

// TopにLocation
header("Location: ./top.php");
