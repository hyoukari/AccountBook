<?php

// 初期処理
require_once(__DIR__ . "/../Libs/init.php");
// ログアウト処理
unset($_SESSION["auth"]);
//
header("Location: index.php");
