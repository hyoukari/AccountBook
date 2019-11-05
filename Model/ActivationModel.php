<?php
require_once(BASEPATH . "/Model/ModelBase.php");

class ActivationModel extends ModelBase
{
    // テーブル名
    protected static $table = "activation";
    // Primary Key
    protected static $pk = "token";

    // 先にTTLが過去の情報を削除
    public static function deletePast()
    {
        $sql = "DELETE FROM activation WHERE ttl < now();";
        static::getDbHandle()->query($sql);
    }
}
