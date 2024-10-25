<?php

$str = file_get_contents("/proc/stat");

preg_match_all("@(?P<cpu>cpu[0-9]*)\s+(?P<user>[0-9]+)\s+(?P<nice>[0-9]+)\s+(?P<system>[0-9]+)\s+(?P<idle>[0-9]+)\s+(?P<iowait>[0-9]+)\s+(?P<irq>[0-9]+)\s+(?P<softirq>[0-9]+)\s+(?P<steal>[0-9]+)@mi", $str, $m);

header("Content-Type: text/plain; charset=UTF-8");

echo('# HELP servercheck_cpu_percent The percent a CPU is used'.PHP_EOL);
echo('# TYPE servercheck_cpu_percent gauge'.PHP_EOL);

echo('# HELP servercheck_cpu_proctime Done CPU processes since start'.PHP_EOL);
echo('# TYPE servercheck_cpu_proctime counter'.PHP_EOL);

echo('# HELP servercheck_cpu_proctsum Done CPU processes since start'.PHP_EOL);
echo('# TYPE servercheck_cpu_proctsum counter'.PHP_EOL);


for ($i = 0; $i < count($m["cpu"]); $i++) {
    $Idle = $m["idle"][$i] + $m["iowait"][$i];

    $NonIdle = $m["user"][$i] + $m["nice"][$i] + $m["system"][$i] + $m["irq"][$i] + $m["softirq"][$i] + $m["steal"][$i];

    /*$PrevTotal = $PrevIdle + $PrevNonIdle;
    $Total = $Idle + $NonIdle;

    $totald = $Total - $PrevTotal;
    $idled = $Idle - $PrevIdle;

    $percent[$i] = ($totald - $idled)/$totald;*/

    echo('servercheck_cpu_proctime{cpu="'.$i.'",type="user"} '.$m["user"][$i].PHP_EOL);
    echo('servercheck_cpu_proctime{cpu="'.$i.'",type="nice"} '.$m["nice"][$i].PHP_EOL);
    echo('servercheck_cpu_proctime{cpu="'.$i.'",type="system"} '.$m["system"][$i].PHP_EOL);
    echo('servercheck_cpu_proctime{cpu="'.$i.'",type="irq"} '.$m["irq"][$i].PHP_EOL);
    echo('servercheck_cpu_proctime{cpu="'.$i.'",type="softirq"} '.$m["softirq"][$i].PHP_EOL);
    echo('servercheck_cpu_proctime{cpu="'.$i.'",type="steal"} '.$m["steal"][$i].PHP_EOL);
    echo('servercheck_cpu_proctime{cpu="'.$i.'",type="idle"} '.$m["idle"][$i].PHP_EOL);
    echo('servercheck_cpu_proctime{cpu="'.$i.'",type="iowait"} '.$m["iowait"][$i].PHP_EOL);

    echo('servercheck_cpu_proctsum{cpu="'.$i.'",type="idle"} '.$Idle.PHP_EOL);
    echo('servercheck_cpu_proctsum{cpu="'.$i.'",type="nonidle"} '.$NonIdle.PHP_EOL);

}


/* DISK */
$ds = disk_total_space("/");
$df = disk_free_space("/");

echo('# HELP servercheck_disk_total_bytes The size of the Drive'.PHP_EOL);
echo('# TYPE servercheck_disk_total_bytes gauge'.PHP_EOL);
echo('servercheck_disk_total_bytes '.$ds.PHP_EOL);
echo('# HELP servercheck_disk_free_bytes The free size of the Drive'.PHP_EOL);
echo('# TYPE servercheck_disk_free_bytes gauge'.PHP_EOL);
echo('servercheck_disk_free_bytes '.$df.PHP_EOL);
