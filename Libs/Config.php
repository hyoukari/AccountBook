<?php

class Config
{
    // 外からのnewの禁止
    protected function __construct()
    { }
    // clone禁止
    protected function __clone()
    { }
    // unserialize禁止
    protected function __wakeup()
    { }

    public static function getAll()
    {
        static $conf = null;
        if (null === $conf) {
            // 環境非依存のconfigを読み込んで
            $conf  = require(BASEPATH . "/config.php");
            // 環境依存のconfigを読み込んで
            $conf += require(BASEPATH . "/environment_config.php");
        }
        // 全部return
        return $conf;
    }
}
