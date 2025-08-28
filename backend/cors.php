<?php
// Allow from any origin
header("Access-Control-Allow-Origin: *");
// Allow common methods
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// Allow headers
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
// JSON output
header("Content-Type: application/json; charset=UTF-8");

// If preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}
?>
