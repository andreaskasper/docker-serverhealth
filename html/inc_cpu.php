<?php

$out = array("result" => array());

$str1 = file_get_contents("/proc/stat");
sleep(10);
$str2 = file_get_contents("/proc/stat");

preg_match_all("@(?P<cpu>cpu[0-9]*)\s+(?P<user>[0-9]+)\s+(?P<nice>[0-9]+)\s+(?P<system>[0-9]+)\s+(?P<idle>[0-9]+)\s+(?P<iowait>[0-9]+)\s+(?P<irq>[0-9]+)\s+(?P<softirq>[0-9]+)\s+(?P<steal>[0-9]+)@mi", $str1, $m1);
preg_match_all("@(?P<cpu>cpu[0-9]*)\s+(?P<user>[0-9]+)\s+(?P<nice>[0-9]+)\s+(?P<system>[0-9]+)\s+(?P<idle>[0-9]+)\s+(?P<iowait>[0-9]+)\s+(?P<irq>[0-9]+)\s+(?P<softirq>[0-9]+)\s+(?P<steal>[0-9]+)@mi", $str2, $m2);


for ($i = 0; $i < count($m1["cpu"]); $i++) {
    $PrevIdle = $m1["idle"][$i] + $m1["iowait"][$i];
    $Idle = $m2["idle"][$i] + $m2["iowait"][$i];

    $PrevNonIdle = $m1["user"][$i] + $m1["nice"][$i] + $m1["system"][$i] + $m1["irq"][$i] + $m1["softirq"][$i] + $m1["steal"][$i];
    $NonIdle = $m2["user"][$i] + $m2["nice"][$i] + $m2["system"][$i] + $m2["irq"][$i] + $m2["softirq"][$i] + $m2["steal"][$i];

    $PrevTotal = $PrevIdle + $PrevNonIdle;
    $Total = $Idle + $NonIdle;

    $totald = $Total - $PrevTotal;
    $idled = $Idle - $PrevIdle;

    $percent[$i] = ($totald - $idled)/$totald;

}
$percent_total = array_sum($percent)/count($percent);


//Ausgabe:

$out["result"]["txt"] = count($percent)."CPUs/5sec; Total: ".number_format(100*$percent_total,1,",",".")."%; ";
for ($i = 0; $i < count($m1["cpu"]); $i++) {
    $out["result"]["txt"] .= "CPU".$i.":".number_format(100*$percent[$i],0)."%; ";
}
$out["result"]["perf"]["value"] = (100*$percent_total);
$out["result"]["perf"]["unit"] = "%";
$out["result"]["perf"]["label"] = "cpu";

if ($percent_total >= 0.9) $out["result"]["state"] = 2;
else if ($percent_total >= 0.8) $out["result"]["state"] = 1;
else $out["result"]["state"] = 0;

header("Content-Type: application/json");
header("Cache-Control: public, max-age=60, s-maxage=60");
die(json_encode($out));
