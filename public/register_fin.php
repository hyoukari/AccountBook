<?php

// 初期処理
require_once(__DIR__ . "/../Libs/init.php");

// 入力データを取得
$params = ["name", "email", "pw", "pw2"];
$data = [];
foreach ($params as $p) {
    $data[$p] = (string) @$_POST[$p];
}
// var_dump($data);

// validate
$error_flg = [];
// 必須チェック
foreach (["email", "pw", "pw2"] as $p) {
    if (empty($data[$p])) {
        $error_flg["error_must_{$p}"] = true;
    }
}

// emailのvalidata
if (false === filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
    $error_flg["error_email_valid"] = true;
}
// pwの長さ(max_length)
// XXX PASSWORD_BCRYPT だと最大72文字なのでやむを得ず
if (72 < strlen($data["pw"])) {
    $error_flg["error_pw_to_long"] = true;
}
// pwとpw2おチェック
if ($data["pw"] !== $data["pw2"]) {
    $error_flg["error_pw_nomatch"] = true;
}


if ([] !== $error_flg) {
    // 入力ページに戻す
    $_SESSION["register"]["error"] = $error_flg;
    // PW情報を抜いてから渡す
    unset($data["pw"]);
    unset($data["pw2"]);
    $_SESSION["register"]["post"] = $data;
    header("Location: ./register.php");
    return;
}

// DBハンドルの取得
$dbh = DB::getHandle();

// 会員情報のinsert
$sql = "INSERT INTO users(name, email, pw) VALUES(:name, '', :pw)";
$pre = $dbh->prepare($sql);
//
$pre->bindValue(':name', $data['name'], \PDO::PARAM_STR);
$pre->bindValue(":pw", password_hash($data["pw"], PASSWORD_DEFAULT), \PDO::PARAM_STR);
//
$res = $pre->execute();
if (false == $res) {
    // XXX
    echo "INSERT失敗";
    exit;
}

// user_idの取得
$user_id = $dbh->lastInsertId();
// アクティベーションのINSERT
$sql = "INSERT INTO activation(token, user_id, email, ttl) VALUES(:token, :user_id, :email, :ttl)";
$pre = $dbh->prepare($sql);
//
$token = bin2hex(random_bytes(128));
//
$pre->bindValue(":token", $token, \PDO::PARAM_STR);
$pre->bindValue(":user_id", $user_id, \PDO::PARAM_STR);
$pre->bindValue(":email", $data["email"], \PDO::PARAM_STR);
$pre->bindValue(":ttl", date(DATE_ATOM, time() + 10800), \PDO::PARAM_STR); // 3時間
// $res = $pre->execute(array(
//     ":token" => XXX,
//     ":user_id" => $user_id,
//     ":email" => $data["email"],
//     ":ttl", date(DATE_ATOM, time() + 10800)
// ));

//
$res = $pre->execute();
if (false == $res) {
    // XXX
    echo "INSERT失敗";
    exit;
}
//
// var_dump($user_id, $token);

// アクティベーションmailの送信
$message = new Swift_Message();
$message->setFrom("test@dev2.m-fr.net");
// $message->setTo($data["email"]);
$message->setTo("ipuvihl22v7q@sute.jp");
$message->setSubject("AccountBook アクティベーションメール");
$param = ["token" => $token, "name" => $data["name"]];
$body = $twig->render("activation_mail.twig", $param);
// var_dump($body);
//
$message->setBody($body);

//
$mailer = new Swift_Mailer(new Swift_SmtpTransport("localhost", 25));
$r = $mailer->send($message);

// 完了画面の出力(Location)
// test用、一時的にコメントアウト
header("Location: ./register_success.php");
