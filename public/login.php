<?php
// 初期処理
require_once(__DIR__ . "/../Libs/init.php");
//
require_once(BASEPATH . "/Model/UsersModel.php");


// 入力値の取得
$email = (string) $_POST["email"] ?? "";
$pw = (string) $_POST["pw"] ?? "";
// var_dump($email, $pw);
if (("" === $email) || ("" === $pw)) {
    header("Location: index.php");
    exit;
}
// var_dump($user);
// usersテープルから該当レコードを把握
$user = UsersModel::findBy(["email" => $email]);
// var_dump($user);
if (null === $user) {
    // 該当ユーザが存在しなかったら突っ返す
    header("Location: index.php");
    exit;
}
// var_dump($pw);
// パスワードを比較
if (false === password_verify($pw, $user->pw)) {
    // パスワードチェックでNGなら突っ返す
    header("Location: index.php");
    exit;
}

// XXX ここまで来たら認証OK
echo "auth ok";

//
session_regenerate_id(true);

// 「認証OK」のマーキング
$_SESSION["auth"]["name"] = $user->name;
$_SESSION["auth"]["user_id"] = $user->user_id;
// var_dump($_SESSION["auth"]);

// 「認証後TopPage」への遷移
header("Location: top.php");
