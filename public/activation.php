<?php
// 初期処理
require_once(__DIR__ . "./../Libs/init.php");

// DBハンドルの取得
$dbh = DB::getHandle();

// 先にTTLが過去の情報を削除
$sql = "DELETE FROM activation WHERE ttl < now();";
$dbh->query($sql);

// tokenの取得
$token = (string) @$_GET["token"];

// DBにtokenがあるか？を確認
$sql = "SELECT * FROM activation WHERE token=:token;";
$pre = $dbh->prepare($sql);
$res = $pre->execute(array(
    ":token" => $token
));
$row = $pre->fetch();
// var_dump($row);

// tokenがなかったらNG
if (empty($row)) {
    echo "ない";
} else {
    // tokenがあったら
    // 対象のuser_idのemailをupdateして
    $sql = "UPDATE users SET email=:email WHERE user_id=:user_id;";
    $pre = $dbh->prepare($sql);
    $res = $pre->execute(array(
        ":email" => $row["email"],
        ":user_id" => $row["user_id"],
    ));
    // tokenを削除
    $sql = "DELETE FROM activation WHERE token=:token;";
    $pre = $dbh->prepare($sql);
    $res = $pre->execute(array(
        ":token" => $token
    ));
    echo "アクティベーション成功";
    exit;
}

// 完了画面

// 終了処理
require_once(BASEPATH . "/Libs/fin.php");
