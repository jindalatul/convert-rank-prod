<?php
ini_set("display_errors","Off");
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

$envPath = dirname(dirname(__DIR__)) . '/env/env.php';
//echo "envPath",$envPath ; //die();

require_once($envPath);

//var_dump($credentials);

function sendJSON($data,$code)
{
    http_response_code($code);

    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: http://localhost:3000");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");

    echo json_encode($data);
}

function sendError($message, $code = 400) 
{
    http_response_code($code);
    echo json_encode(['error' => $message]);
    exit();
}

function sendSuccess($data) 
{
    http_response_code(200);
    echo json_encode($data);
    exit();
}
?>