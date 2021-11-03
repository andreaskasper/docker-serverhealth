<?php

$out = array("result" => array());

$str = file_get_contents("/proc/mdstat");
preg_match_all("@(?P<name>md[0-9]+).+?(?P<raid>raid[0-9]+).+?(?P<size>[0-9]+) blocks.+?\[(?P<disk>[_U]+)\]@si", $str, $m);
$is_okay = true;
$hdds = 0;
foreach ($m["disk"] as $a) {
    $hdds += strlen($a);
    if (strpos($a, "_") !== false) $is_okay = false;
}

exec("lsblk", $rows2);

if ($is_okay) {
    $out["result"]["state"] = 0;
} else {
    $out["result"]["state"] = 2;
}

$out["result"]["txt"] = count($m["disk"])."raid2s, ".$hdds."HDDs, ".implode("", $m["disk"])." ".implode(" ", $m["raid"]).PHP_EOL.$str.PHP_EOL.PHP_EOL.implode(PHP_EOL, $rows2);

header("Content-Type: application/json");
header("Cache-Control: public, max-age=60, s-maxage=60");
die(json_encode($out));
