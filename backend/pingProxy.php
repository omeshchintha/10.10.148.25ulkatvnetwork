<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

// OPTIONS request ki response
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// target and path validation
if (!isset($_GET['target']) || !isset($_GET['path'])) {
    http_response_code(400);
    echo json_encode(["status"=>"error","message"=>"Missing target or path"]);
    exit;
}

$target = $_GET['target']; // Example: 192.168.80.2
$path   = $_GET['path'];   // Example: backend/pingProxy.php

// extra query parameters (r=0.123 etc)
$queryString = $_SERVER['QUERY_STRING'];
parse_str($queryString, $params);
unset($params['target'], $params['path']);
$qs = http_build_query($params);

// build full URL
$url = "http://{$target}/{$path}" . ($qs ? "?$qs" : "");

// Initialize cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10); // timeout 10 seconds

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents("php://input"));
}

// Execute cURL
$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErr  = curl_error($ch);
curl_close($ch);

// Check if cURL failed
if ($response === false) {
    http_response_code(500);
    echo json_encode(["status"=>"error","message"=>"Curl failed: $curlErr"]);
    exit;
}

// Return response with original HTTP code
http_response_code($httpcode);
echo $response;
