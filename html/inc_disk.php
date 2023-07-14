<?php

$out = array("result" => array());

if (!empty($_GET["warn"]) AND is_numeric($_GET["warn"])) $warn = $_GET["warn"]+0; else $warn = 80;
if (!empty($_GET["crit"]) AND is_numeric($_GET["crit"])) $crit = $_GET["crit"]+0; else $crit = 95;

$ds = disk_total_space("/");
$df = disk_free_space("/");
$du = $ds-$df;
$proz = 100-(100*$df/$ds);

if ($proz >= $crit) $out["result"]["state"] = 2;
elseif ($proz >= $warn) $out["result"]["state"] = 1;
else $out["result"]["state"] = 0;
$out["result"]["txt"] = "Free: ".formatBytes($df, 1)."/".formatBytes($ds, 1)." => ".round(100-$proz, 1)."% left ---- ".round($proz, 1)."% full\nUsage: ".formatBytes($du, 1);

$out["result"]["perf"]["value"] = round(100-$proz, 2);
$out["result"]["perf"]["unit"] = "%";
$out["result"]["perf"]["label"] = "diskfree";


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
