<?php
// ping_clients.php — 10.10.148.25 server nundi clients ki ping run chesi JSON + log save chestundi

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// (A) simple token security
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

// (B) load clients
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

// (C) ping helper (Ubuntu: iputils-ping). Count & timeout tune cheyyachu.
function ping_host($ip, $count = 3, $timeout = 2) {
    // NOTE: www-data user ki ping run cheyyadaniki permissions undali.
    // If not: sudo setcap cap_net_raw+ep /bin/ping
    $cmd = sprintf('ping -c %d -W %d %s 2>&1', $count, $timeout, escapeshellarg($ip));
    $out = shell_exec($cmd);
    if ($out === null) {
        return ["status"=>"error", "error"=>"exec_failed", "raw"=>null];
    }

    // packets line
    $tx = $rx = null; $loss = null;
    if (preg_match('/(\d+)\s+packets transmitted,\s+(\d+)\s+received,\s+([\d\.]+)%\s+packet loss/i', $out, $m)) {
        $tx   = (int)$m[1];
        $rx   = (int)$m[2];
        $loss = (float)$m[3];
    }

    // rtt line (covers rtt/round-trip & mdev/stddev variants)
    $min = $avg = $max = $mdev = null;
    if (
        preg_match('/rtt\s+min\/avg\/max\/(?:mdev|stddev)\s*=\s*([\d\.]+)\/([\d\.]+)\/([\d\.]+)\/([\d\.]+)\s*ms/i', $out, $r) ||
        preg_match('/round-trip\s+min\/avg\/max\/(?:mdev|stddev)\s*=\s*([\d\.]+)\/([\d\.]+)\/([\d\.]+)\/([\d\.]+)\s*ms/i', $out, $r)
    ) {
        $min  = (float)$r[1];
        $avg  = (float)$r[2];
        $max  = (float)$r[3];
        $mdev = (float)$r[4];
    }

    $up = ($rx !== null && $rx > 0 && $loss !== null && $loss < 100.0);
    return [
        "status"       => $up ? "up" : "down",
        "sent"         => $tx,
        "received"     => $rx,
        "packet_loss"  => $loss,
        "rtt_min_ms"   => $min,
        "rtt_avg_ms"   => $avg,
        "rtt_max_ms"   => $max,
        "rtt_mdev_ms"  => $mdev,
        "raw"          => $out
    ];
}

// (D) run pings
$results = [];
foreach ($clients as $c) {
    $ip = $c['ip'];
    $name = $c['name'] ?? $ip;
    $r = ping_host($ip, 3, 2);
    $results[] = [
        "name"   => $name,
        "ip"     => $ip,
        "result" => $r
    ];
}

// (E) append to log (JSON lines)
$logLine = json_encode([
    "timestamp" => date("c"),
    "server"    => gethostbyname(gethostname()),
    "results"   => $results
], JSON_UNESCAPED_SLASHES);

@file_put_contents(__DIR__ . "/pings.log", $logLine . PHP_EOL, FILE_APPEND);

// (F) output JSON
echo json_encode([
    "status"  => "ok",
    "message" => "Ping completed from 10.10.148.25",
    "count"   => count($results),
    "results" => $results
], JSON_UNESCAPED_SLASHES);
