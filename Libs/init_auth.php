<?php
// 初期処理
require_once(__DIR__ . "/init.php");

// 認可チェック
if (false === isset($_SESSION["auth"])) {
    header("Location: index.php");
    exit;
}
