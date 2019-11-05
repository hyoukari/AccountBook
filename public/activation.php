<?php
// 初期処理
require_once(__DIR__ . "./../Libs/init.php");
// 
require_once(BASEPATH . "/Model/UsersModel.php");
require_once(BASEPATH . "/Model/ActivationModel.php");


// DBハンドルの取得
$dbh = DB::getHandle();

// 先にTTLが過去の情報を削除
$sql = "DELETE FROM activation WHERE ttl < now();";
$dbh->query($sql);

// tokenの取得
$token = (string) @$_GET["token"];

// DBにtokenがあるか？を確認
$activation = ActivationModel::find($token);
if (empty($activation)) {
    // XXX
    echo "ない";
    exit;
} else {
    // tokenがあったら
    // XXX BEGIN
    // 対象のuser_idのemailをupdateして
    $user = UsersModel::find($activation->user_id);
    $user->email = $activation->email;
    $user->update();

    // tokenを削除
    $activation->delete();
    // XXX commit

    // XXX 
    echo "アクティベーション成功";
    exit;
}


// 完了画面

// 終了処理
require_once(BASEPATH . "/Libs/fin.php");
