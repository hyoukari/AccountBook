<?php
require_once(BASEPATH . "/Model/ModelBase.php");

class UsersModel extends ModelBase
{
    // テーブル名
    protected static $table = "users";
    // Primary Key
    protected static $pk = "user_id";
}
