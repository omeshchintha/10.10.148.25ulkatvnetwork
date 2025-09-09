<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json");

// target server IP
if (!isset($_GET['target'])) {
    echo json_encode(["error" => "No target provided"]);
    exit;
}

$target = escapeshellarg($_GET['target']); 
$pingCmd = "ping -c 3 -W 2 $target"; 
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
    if (preg_match('/rtt min\/avg\/max\/mdev = .*\/(.*)\/.*\/.*/', $line, $matches)) {
        $latency = round(floatval($matches[1]), 2);
    }
}

echo json_encode([
    "status" => "ok",
    "target" => $_GET['target'],
    "latency_ms" => $latency,
    "raw" => $output
]);
?>
