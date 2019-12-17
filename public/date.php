<?php
// from
list($y, $m) = explode("-", date("Y-m"));
$d1 = "{$y}-{$m}-1";
var_dump($d1);

// to
$d2 = date("Y-m-d", strtotime("last day of this month", strtotime($d1)));
var_dump(date($d2));
