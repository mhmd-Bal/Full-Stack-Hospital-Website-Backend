<?php
include('connection.php');
require_once('jwt/src/JWT.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$email = $_POST['email'];
$password = $_POST['password'];

$query = $mysqli->prepare('select id,user_name,email,usertype_id,password from users where email=?');
$query->bind_param('s', $email);
$query->execute();

$query->store_result();
$user_doesnt_exist = $query->num_rows();
$query->bind_result($id, $name,$email,$usertype_id,$hashed_password);
$query->fetch();
$response = [];

if ($user_doesnt_exist == 0) {
    $response['response'] = "Email not found";
    
} else {
    if (password_verify($password, $hashed_password)) {

        $key = "hospital_secret_key";
        $payload = [];
        $payload['sub'] = $id;
        $payload['name'] = $name;
        $payload['usertype'] = $usertype_id;

        $jwt = JWT::encode($payload, $key, 'HS256');
        $response['response'] = "logged in";
        $response['token'] = $jwt;
        $response['usertype'] = $usertype_id;

    } else {
      $response["response"] = "Incorrect email or password";
    }
}
 
echo json_encode($response);
?>