<?php
// ✅ CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

// ✅ Handle preflight OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// ✅ Read input JSON
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode([
        "status" => "error",
        "message" => "No data received"
    ]);
    exit;
}

// ✅ Example: save to log file
file_put_contents("results.log", json_encode($data) . PHP_EOL, FILE_APPEND);

// ✅ Response
echo json_encode([
    "status" => "success",
    "message" => "Results saved",
    "received" => $data
]);
