<?php
include('connection.php');
require_once('jwt/src/JWT.php');
require_once('jwt/src/Key.php');
require_once('jwt/src/SignatureInvalidException.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$jwt = $_POST['token'];
$key = "hospital_secret_key";
$response = [];


try {
  $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
  $decoded_array = (array) $decoded;
  $response['Authentication'] = "Successful";
  $response['name'] = $decoded_array['name'];
  $response['email'] = $decoded_array['sub'];
  $response['usertype'] = $decoded_array['usertype'];
}catch (SignatureInvalidException $e){
  $response['Authentication'] = "Failed";
}catch (UnexpectedValueException $e){
  $response['Authentication'] = "Failed";
}

echo json_encode($response);
