<?php
// 初期処理
require_once(__DIR__ . "/../Libs/init.php");
require_once(BASEPATH . "/Model/PasswordReminderModel.php");
require_once(BASEPATH . "/Model/UsersModel.php");

// tokenを把握
$token = (string) $_POST["token"] ?? "";
// var_dump($token);

// tokenの有効性をチェック
PasswordReminderModel::deletePast();
$m_obj = PasswordReminderModel::find($token);
var_dump($m_obj);
// 
if (null === $m_obj) {
    // xxx
    echo "tokenが存在しない";
    exit;
}

// 入力されたパスワードの確認
$pw = (string) $_POST["pw"] ?? "";
$pw2 = (string) $_POST["pw2"] ?? "";
// XXX register_fin.php に同じ処理があるので後で共通化
if (("" === $pw) || ($pw !== $pw2)) {
    // XXX
    echo "パスワードがおかしい";
}

// -- ここまで来たら「tokenもパスワードもok」
// DBハンドルの取得
$dbh = DB::getHandle();
// トランザクション開始
$dbh->beginTransaction();
try {
    // 対象ユーザのパスワード情報を変更
    $u_obj = UsersModel::find($m_obj->user_id); // XXX エラーチェック省略
    var_dump($u_obj);
    $u_obj->pw = password_hash($pw, PASSWORD_DEFAULT); // XXX ここも共通化
    // 
    $r = $u_obj->update();
    if (false === $r) {
        throw new \Exception("users");
    }
    // tokenの削除
    $r = $m_obj->delete();
    if (false === $r) {
        throw new \Exception("password_reminder");
    }
} catch (\Exception $e) {
    // 失敗
    $dbh->rollback();
    echo "DBで失敗した";
    exit;
}
// トランザクション終了
$dbh->commit();

// パスワード変更Pageを出力
header("Location: ./reminder_success.php");
// XXXXXXX
