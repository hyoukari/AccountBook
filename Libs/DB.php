<?php
/*
// 使用イメージ
$dbh = DB::getHandle(); // DB接続ハンドル(PDO)を得られる
*/
require_once(BASEPATH . "/Libs/Config.php");

class DB
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

    public static function getHandle()
    {
        static $dbh = null;
        if (null === $dbh) {
            $conf = Config::getAll();
            try {
                $dbname = $conf["DB"]["dbname"];
                $host = $conf["DB"]["host"];
                $user = $conf["DB"]["user"];
                $pass = $conf["DB"]["pass"];
                $dsn = "mysql:dbname={$dbname}; host={$host}; charset=utf8mb4";
                $option = [
                    // 静的プレースホルダを指定
                    PDO::ATTR_EMULATE_PREPARES => false,
                    // 複文実行を禁止
                    PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
                ];
                $dbh = new PDO($dsn, $user, $pass, $option);
            } catch (PDOException $e) {
                echo $e->getMessage();
                exit;
            }
        }
        return $dbh;
    }
}
