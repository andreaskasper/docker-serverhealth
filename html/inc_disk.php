<?php

$out = array("result" => array());

$ds = disk_total_space("/");
$df = disk_free_space("/");

$out["result"]["state"] = 0;
$out["result"]["txt"] = "Free: ".$df."/".$ds;



header("Content-Type: application/json");
header("Cache-Control: public, max-age=60, s-maxage=60");
die(json_encode($out));
