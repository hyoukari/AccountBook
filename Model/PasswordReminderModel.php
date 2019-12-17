<?php
// 
require_once(BASEPATH . "/Model/ModelBase.php");
// 
class PasswordReminderModel extends ModelBase
{
    // テーブル名
    protected static $table = "password_reminder";
    // Primary key
    protected static $pk = "token";

    // 「TTLが過去の情報」を削除
    public static function deletePast()
    {
        $sql = "DELETE FROM password_reminder WHERE ttl < now();";
        static::getDbHandle()->query($sql);
    }
}
