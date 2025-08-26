<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit(0);
}

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

// ✅ Always return JSON response
echo json_encode([
    "status" => "success",
    "message" => "Results saved",
    "received" => $data
]);
