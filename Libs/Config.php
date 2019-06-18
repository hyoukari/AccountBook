<?php

class Config
{
    public static function getAll()
    {
        static $conf = null;
        if (null === $conf) {
            // 環境依存のconfigを読み込んで
            $conf = require(BASEPATH . "/environment_config.php");
        }
        // 全部return
        return $conf;
    }
}
