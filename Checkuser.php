<?php
include('connection.php');
require_once('jwt/src/JWT.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$token = $_POST['token'];
$mykey = "hospital_secret_key";
$response = [];

if(isset($token)){
  $decoded = JWT::decode($token, new Key($mykey, 'HS256'));
  $decoded_array = (array) $decoded;
  $response['Authentication'] = "Successful";
}else{
  $response['Authentication'] = "Failed";
}

echo json_encode($response);
