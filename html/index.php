<?php

if (!empty($_ENV["API_KEY"])) {
    if ($_ENV["API_KEY"] != ($_GET["token"] ?? $_GET["apikey"] ?? "")) {
        http_response_code(403);
        exit;
    }
}

$_SERVER["REQUEST_URI2"] = substr($_SERVER["REQUEST_URI"],strlen($_SERVER["SCRIPT_NAME"])-10);
$_SERVER["REQUEST_URIpure"] = strtok($_SERVER["REQUEST_URI2"], '?');

switch ($_SERVER["REQUEST_URIpure"]) {
    case "/nagios/raid.json":
        require_once(__DIR__."/inc_raid.php");
        exit;
    case "/nagios/cpu.json":
        require_once(__DIR__."/inc_cpu.php");
        exit;
    case "/nagios/disk.json":
        require_once(__DIR__."/inc_disk.php");
        exit;
    case "/metrics":
        require_once(__DIR__."/inc_prometheus.metrics.php");
        exit;
    default:
        http_response_code(404);
        exit;
}
