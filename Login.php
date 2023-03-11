<?php
include('connection.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

$email = $_POST['email'];
$password = $_POST['password'];

$query = $mysqli->prepare('select id,name,email,password from users where email=?');
$query->bind_param('s', $email);
$query->execute();

$query->store_result();
$user_doesnt_exist = $query->num_rows();
$query->bind_result($id, $name,$email,$hashed_password);
$query->fetch();
$response = [];

if ($user_doesnt_exist == 0) {
    $response['response'] = "Email not found";
    
} else {
    if (password_verify($password, $hashed_password)) {
      $response['response'] = "logged in";
      $response['email'] = $email;
      $response['id'] = $id;
      $response['name'] = $name;
      $response['email'] = $email;
    } else {
     $response["response"] = "Incorrect email or password";
    }
}
 
echo json_encode($response);
?>