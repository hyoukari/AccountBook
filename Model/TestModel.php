<?php
require_once(BASEPATH . "/Model/ModelBase.php");

class TestModel extends ModelBase
{
    // table
    protected static $table = "test";
    //  pk
    protected static $pk = "id";
}
