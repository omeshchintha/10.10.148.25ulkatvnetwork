<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

set_time_limit(0);

$to = $_GET['to'] ?? '';
$duration = 20; // fixed 20 seconds

if (!$to) {
    echo json_encode(["status" => "error", "message" => "No target server given"]);
    exit;
}

$result = [
    "status" => "ok",
    "ping_ms" => null,
    "jitter_ms" => null,
    "download_mbps" => null,
    "upload_mbps" => null
];

// ------------------- PING + JITTER -------------------
$pingCmd = sprintf("ping -c 5 -q %s", escapeshellarg($to));
exec($pingCmd, $out, $ret);

if ($ret === 0 && !empty($out)) {
    $line = implode(" ", $out);
    if (preg_match('/rtt min\/avg\/max\/mdev = ([0-9.]+)\/([0-9.]+)\/([0-9.]+)\/([0-9.]+)/', $line, $m)) {
        $result["ping_ms"] = floatval($m[2]);
        $result["jitter_ms"] = floatval($m[4]);
    }
}

// ------------------- DOWNLOAD TEST -------------------
$downloadUrl = "http://$to/ulkatvnetwork/backend/garbage.php";

$ch = curl_init($downloadUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_TIMEOUT, $duration);

$bytesDownloaded = 0;
$start = microtime(true);

curl_setopt($ch, CURLOPT_WRITEFUNCTION, function($ch, $data) use (&$bytesDownloaded, $start, $duration) {
    $bytesDownloaded += strlen($data);
    if ((microtime(true) - $start) >= $duration) {
        return 0; // stop after $duration sec
    }
    return strlen($data);
});

curl_exec($ch);
curl_close($ch);

$timeTaken = microtime(true) - $start;
if ($timeTaken > 0) {
    $result["download_mbps"] = round(($bytesDownloaded * 8) / ($timeTaken * 1024 * 1024), 2);
}

// ------------------- UPLOAD TEST -------------------
$uploadUrl = "http://$to/ulkatvnetwork/backend/empty.php";
$bytesSent = 0;
$startTime = microtime(true);

$ch = curl_init($uploadUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_TIMEOUT, $duration);

$chunk = str_repeat("A", 1024 * 1024); // 1 MB

curl_setopt($ch, CURLOPT_READFUNCTION, function($ch, $fd, $length) use (&$bytesSent, $chunk, $startTime, $duration) {
    if ((microtime(true) - $startTime) >= $duration) {
        return ""; // stop after $duration sec
    }
    $bytesSent += strlen($chunk);
    return $chunk;
});

curl_exec($ch);
curl_close($ch);

$elapsed = microtime(true) - $startTime;
if ($bytesSent > 0 && $elapsed > 0) {
    $result["upload_mbps"] = round(($bytesSent * 8) / ($elapsed * 1024 * 1024), 2);
}

// ------------------- OUTPUT -------------------
echo json_encode($result);
exit;
