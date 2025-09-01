<?php
$to = $_GET['to'] ?? '';
if (!$to) {
    echo json_encode(["status" => "error", "message" => "No server specified"]);
    exit;
}

// ----------------------
// 🟢 PING Calculation
// ----------------------
exec("ping -c 5 " . escapeshellarg($to), $output, $retval);
$pings = [];
foreach ($output as $line) {
    if (preg_match('/time=([\d\.]+)/', $line, $matches)) {
        $pings[] = floatval($matches[1]);
    }
}

$ping = 0;
$jitter = 0;
if (count($pings) > 0) {
    $ping = array_sum($pings) / count($pings);
    $jitter = max($pings) - min($pings);
}

// ----------------------
// 🟢 DOWNLOAD Test (garbage.php)
// ----------------------
$downloadUrl = "http://$to/backend/garbage.php?ckSize=10"; // 10 MB test
$start = microtime(true);
$data = @file_get_contents($downloadUrl);
$end = microtime(true);

$downloadSpeed = 0;
if ($data !== false) {
    $size = strlen($data) / (1024 * 1024); // MB
    $time = $end - $start; // seconds
    if ($time > 0) {
        $downloadSpeed = round($size / $time, 2); // MBps
    }
}

// ----------------------
// 🟢 UPLOAD Test (empty.php)
// ----------------------
$uploadUrl = "http://$to/backend/empty.php";
$postData = str_repeat("0", 5 * 1024 * 1024); // 5MB dummy data

$start = microtime(true);
$opts = ['http' => [
    'method'  => 'POST',
    'header'  => "Content-Type: application/octet-stream\r\n",
    'content' => $postData
]];
$context  = stream_context_create($opts);
$result = @file_get_contents($uploadUrl, false, $context);
$end = microtime(true);

$uploadSpeed = 0;
if ($result !== false) {
    $size = strlen($postData) / (1024 * 1024); // MB
    $time = $end - $start; // seconds
    if ($time > 0) {
        $uploadSpeed = round($size / $time, 2); // MBps
    }
}

// ----------------------
// 🟢 Final Response
// ----------------------
echo json_encode([
    "status" => "ok",
    "ping_ms" => round($ping, 2),
    "jitter_ms" => round($jitter, 2),
    "download_mbps" => round($downloadSpeed * 8, 2), // Convert MBps → Mbps
    "upload_mbps"  => round($uploadSpeed * 8, 2)     // Convert MBps → Mbps
]);

?>
