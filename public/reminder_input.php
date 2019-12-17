<?php
// 初期処理
require_once(__DIR__ . "/../Libs/init.php");
require_once(BASEPATH . "/Model/PasswordReminderModel.php");

// tokenを把握
$token = trim((string) $_GET["token"] ?? "");
var_dump($token);

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

// token含めて「パスワード再設定」画面の出力
//
$template_file_name = "reminder_input.twig";
$template_data = ["token" => $m_obj->token];
// 終了処理
require_once(BASEPATH . "/Libs/fin.php");
