<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if (!isset($_GET['target']) || !isset($_GET['path'])) {
    http_response_code(400);
    echo "Missing target or path";
    exit;
}

$target = $_GET['target']; // 103.98.7.234
$path   = $_GET['path'];   // backend/pingProxy.php

// extra query parameters (r=0.123 etc)
$queryString = $_SERVER['QUERY_STRING'];
// remove target & path from query string
parse_str($queryString, $params);
unset($params['target']);
unset($params['path']);
$qs = http_build_query($params);

$url = "http://{$target}/{$path}".($qs ? "?$qs" : "");

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents("php://input"));
}

$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

http_response_code($httpcode);
echo $response;
