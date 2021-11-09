<?php

$out = array("result" => array());

$ds = disk_total_space("/");
$df = disk_free_space("/");

if ($df >= $ds*0.9) $out["result"]["state"] = 2;
elseif ($df >= $ds*0.8) $out["result"]["state"] = 1;
else $out["result"]["state"] = 0;
$out["result"]["txt"] = "Free: ".formatBytes($df,1)."/".formatBytes($ds,1);


header("Content-Type: application/json");
header("Cache-Control: public, max-age=60, s-maxage=60");
die(json_encode($out));

function formatBytes($bytes, $precision = 2) { 
    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 
    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 
    $bytes /= (1 << (10 * $pow)); 
    return round($bytes, $precision) . ' ' . $units[$pow]; 
} 
