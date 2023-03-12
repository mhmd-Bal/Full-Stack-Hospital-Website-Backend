<?php
include("Connection.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

$name = $_POST['name'];
$dob = $_POST['dob'];
$email = $_POST['email'];
$password = $_POST['password'];

$check_email = $mysqli -> prepare('select email from users where email=?');
$check_email -> bind_param('s', $email);
$check_email -> execute();
$check_email -> store_result();
$email_exists = $check_email->num_rows();

$hashed_password = password_hash($password, PASSWORD_BCRYPT);

if($email_exists > 0){
  $response['status'] = "Failed: Email Already Exists!";
}else{
  $query = $mysqli -> prepare('insert into users(user_name, email, password, dob, usertype_id) values(?,?,?,?,2)');
  $query -> bind_param('ssss', $name, $email, $hashed_password, $dob);
  $query -> execute();
  $response['status'] = "User Added!";
}

echo json_encode($response);
