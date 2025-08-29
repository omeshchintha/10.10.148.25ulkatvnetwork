<?php
header("Content-Type: application/json");

// target server IP
if (!isset($_GET['target'])) {
    echo json_encode(["error" => "No target provided"]);
    exit;
}

$target = escapeshellarg($_GET['target']); // prevent injection
$pingCmd = "ping -c 3 -W 2 $target"; // 3 packets, timeout 2s
$output = [];
$returnVar = 0;

exec($pingCmd, $output, $returnVar);

if ($returnVar !== 0) {
    echo json_encode(["status" => "down", "target" => $_GET['target']]);
    exit;
}

// Parse average latency
$latency = null;
foreach ($output as $line) {
    if (strpos($line, "avg") !== false) {
        // Example: rtt min/avg/max/mdev = 1.234/2.345/3.456/0.789 ms
        preg_match('/= (.*)\/(.*)\/(.*)\/(.*) ms/', $line, $matches);
        if (isset($matches[2])) {
            $latency = round(floatval($matches[2]), 2);
        }
    }
}

echo json_encode([
    "status" => "ok",
    "target" => $_GET['target'],
    "latency_ms" => $latency,
    "raw" => $output
]);
