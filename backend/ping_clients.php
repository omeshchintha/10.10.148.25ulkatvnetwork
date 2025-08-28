<?php
// ping_clients.php — Ping + Speedtest results for clients

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// (A) Simple token security
$API_TOKEN = "CHANGE_ME_TOKEN";
function get_token() {
    if (php_sapi_name() === 'cli') {
        global $argv;
        foreach ($argv as $arg) {
            if (strpos($arg, '--token=') === 0) return substr($arg, 8);
        }
        return null;
    } else {
        return $_GET['token'] ?? $_SERVER['HTTP_X_API_TOKEN'] ?? null;
    }
}
if ($API_TOKEN && get_token() !== $API_TOKEN) {
    http_response_code(403);
    echo json_encode(["status"=>"error","message"=>"Forbidden"]);
    exit;
}

// (B) Load clients
$clientsFile = __DIR__ . "/clients.json";
if (!file_exists($clientsFile)) {
    echo json_encode(["status"=>"error","message"=>"clients.json not found"]);
    exit;
}
$clients = json_decode(file_get_contents($clientsFile), true);
if (!is_array($clients)) {
    echo json_encode(["status"=>"error","message"=>"Invalid clients.json"]);
    exit;
}

// (C) Ping helper
function ping_host($ip, $count = 3, $timeout = 2) {
    $cmd = sprintf('ping -c %d -W %d %s 2>&1', $count, $timeout, escapeshellarg($ip));
    $out = shell_exec($cmd);

    $avg = $mdev = null;
    if (
        preg_match('/rtt\s+min\/avg\/max\/(?:mdev|stddev)\s*=\s*([\d\.]+)\/([\d\.]+)\/([\d\.]+)\/([\d\.]+)\s*ms/i', $out, $r) ||
        preg_match('/round-trip\s+min\/avg\/max\/(?:mdev|stddev)\s*=\s*([\d\.]+)\/([\d\.]+)\/([\d\.]+)\/([\d\.]+)\s*ms/i', $out, $r)
    ) {
        $avg  = (float)$r[2];
        $mdev = (float)$r[4];
    }
    return [$avg, $mdev];
}

// (D) Load latest speedtest results
$speedtestFile = __DIR__ . "/speedtest_results.json";
$spd = [
    "download" => null,
    "upload"   => null,
    "ping"     => null,
    "server"   => ""
];
if (file_exists($speedtestFile)) {
    $data = json_decode(file_get_contents($speedtestFile), true);
    if ($data) {
        $spd = [
            "download" => round($data["download"]/1000000, 2)." Mbps",
            "upload"   => round($data["upload"]/1000000, 2)." Mbps",
            "ping"     => round($data["ping"], 2)." ms",
            "server"   => $data["server"]["sponsor"]." - ".$data["server"]["name"]
        ];
    }
}

// (E) Run pings for all clients
$results = [];
foreach ($clients as $c) {
    $ip = $c['ip'];
    list($ping_val, $jitter_val) = ping_host($ip, 3, 2);

    $results[] = [
        "TestID"        => uniqid("test_"),
        "ServerUsed"    => "http://10.10.148.25/ - ".$spd['server'],
        "IPAddress"     => $ip,
        "Ping"          => $ping_val !== null ? $ping_val." ms" : $spd['ping'],
        "Jitter"        => $jitter_val !== null ? $jitter_val." ms" : "0 ms",
        "DownloadSpeed" => $spd['download'],
        "UploadSpeed"   => $spd['upload'],
        "DateTime"      => date("d/m/Y, H:i:s")
    ];
}

// (F) Save log
@file_put_contents(__DIR__."/pings.log", json_encode($results, JSON_UNESCAPED_SLASHES).PHP_EOL, FILE_APPEND);

// (G) Output JSON
echo json_encode($results, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
