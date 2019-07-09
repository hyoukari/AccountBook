<?php

// 初期処理
require_once(__DIR__ . "/../Libs/init.php");

// 入力データを取得
$params = ["name", "email", "pw", "pw2"];
$data = [];
foreach ($params as $p) {
    $data[$p] = (string) @$_POST[$p];
}
var_dump($data);

// validate
$error_flg = false;
// 必須チェック
foreach (["email", "pw", "pw2"] as $p) {
    if (empty($data[$p])) {
        $error_flg = true;
    }
}

// emailのvalidata
if (false === filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
    $error_flg = true;
}
// pwの長さ(max_length)
// XXX PASSWORD_BCRYPT だと最大72文字なのでやむを得ず
if (72 < strlen($data["pw"])) {
    $error_flg = true;
}
// pwとpw2おチェック
if ($data["pw"] !== $data["pw2"]) {
    $error_flg = true;
}


if (true === $error_flg) {
    // 入力ページに戻す
    $_SESSION["register"]["error"] = true;
    // PW情報を抜いてから渡す
    unset($data["pw"]);
    unset($data["pw2"]);
    $_SESSION["register"]["post"] = $data;
    header("Location: ./register.php");
    return;
}

// 会員情報のinsert
// 完了画面の出力(Location)
