<?php
// === CORS headers (optional) ===
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Credentials: true");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit(); }

header("Content-Type: application/json");

// === Your main logic ===
$data = json_decode(file_get_contents("php://input"), true);
$userInput = $data["message"] ?? "";

echo json_encode([
  "ok" => true,
  "reply" => "Server received: " . $userInput,
  "timestamp" => date("Y-m-d H:i:s")
]);