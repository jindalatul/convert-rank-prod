<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

// ---- DB connection ---- //
$host = "lamp-docker-db-1";
$user = "root";
$pass = "";
$dbname = "hub-spoke";

$conn = mysqli_connect($host, $user, $pass, $dbname);
if (!$conn) {
  echo json_encode(['ok'=>false, 'error'=>'DB connection failed']);
  exit;
}

// ---- Hard-coded user for Phase 1 ---- //
$user_id = 2; // change as needed

// ---- Read raw JSON body ---- //
$input = file_get_contents("php://input");
$data  = json_decode($input, true);

if (!$data) {
  echo json_encode(['ok'=>false, 'error'=>'Invalid JSON']);
  exit;
}

// ---- Session id (temporary unique) ---- //
$session_id = "session_" . time() . "_" . substr(md5(mt_rand()), 0, 6);
$created_at = date('Y-m-d H:i:s');

// ---- Extract fields ---- //
$persona_json   = json_encode($data, JSON_UNESCAPED_UNICODE);
$seed_keywords  = isset($data['seed_keywords']) ? json_encode($data['seed_keywords']) : '[]';
$project_name   = "Content Strategy Project " . date('Y-m-d');

// ---- Escape & insert ---- //
$persona_esc  = mysqli_real_escape_string($conn, $persona_json);
$keywords_esc = mysqli_real_escape_string($conn, $seed_keywords);
$proj_name_esc= mysqli_real_escape_string($conn, $project_name);

$sql = "INSERT INTO projects1 (user_id, project_name, persona, seed_keywords)
        VALUES ($user_id, '$proj_name_esc', '$persona_esc', '$keywords_esc')";

if (mysqli_query($conn, $sql)) {
  echo json_encode(['ok'=>true, 'message'=>'Persona saved', 'session_id'=>$session_id]);
} else {
  error_log("MySQL error: " . mysqli_error($conn));
  echo json_encode(['ok'=>false, 'error'=>'DB insert failed']);
}

mysqli_close($conn);
?>