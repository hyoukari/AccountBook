<?php
// exit;

//
require_once(__DIR__ . "/../Libs/init.php");
//
require_once(BASEPATH . "/Model/TestModel.php");

// insert
$obj = new TestModel();
$obj->i = 999;
$obj->s = "abc";
$r = $obj->insert();
var_dump($r);

$id = DB::getHandle()->lastInsertId();
var_dump($id);

// select
$obj = TestModel::find($id);
var_dump($obj);

// update
$obj->i = mt_rand(0, 9999);
$r = $obj->update();
var_dump($r, $obj);

// delete
$r = $obj->delete();
var_dump($r);
