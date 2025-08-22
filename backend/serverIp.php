<?php
// Server host IP ni detect cheyadam
$serverIp = $_SERVER['SERVER_ADDR'] ?? gethostbyname(gethostname());

header('Content-Type: application/json');
echo json_encode(["serverIp" => $serverIp]);
