<?php

define("BASEPATH", realpath(__DIR__ . "/../"));
require_once(BASEPATH . "/Libs/DB.php");
require_once(BASEPATH . "/Libs/Config.php");
$conf = Config::getAll();
var_dump($conf);

echo "AccountBook";
