<?php
include('connection.php');
require_once('jwt/src/JWT.php');
require_once('jwt/src/Key.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$jwt = $_POST['token'];
$key = "hospital_secret_key";
$response = [];

if(isset($jwt)){
  $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
  $decoded_array = (array) $decoded;
  $response['Authentication'] = "Successful";
  $response['name'] = $decoded_array['name'];
  $response['email'] = $decoded_array['sub'];
  $response['usertype'] = $decoded_array['usertype'];
}else{
  $response['Authentication'] = "Failed";
}

echo json_encode($response);
