<?php
include('connection.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");




$hospital_id = $_POST['hospital_id'];
$user_id = $_POST['user_id'];
$is_active = $_POST['is_active'];
$date_joined = $_POST['date_joined'];
$date_left = $_POST['date_left'];

$check_hospital = $mysqli->prepare('select id from hospitals where id=?');
$check_hospital->bind_param('i', $hospital_id);
$check_hospital->execute();
$check_hospital->store_result();

$hospital_doesnt_exist = $check_hospital->num_rows();
$response = [];

if ($hospital_doesnt_exist == 0) {
  $response['response'] = "Hospital not found";
} else {
  $check_user = $mysqli->prepare('select usertype_id from hospitals where id=?');
  $check_user->bind_param('i', $user_id);
  $check_user->execute();
  $check_user->store_result();
  $check_user->bind_result($usertype_id);
  $check_user->fetch();
  $user_doesnt_exist = $check_user->num_rows();

  if($user_doesnt_exist == 0){
    $response['response'] = "User not found";
  }else{
    if($usertype_id == 1){


    }else{
      $response['response'] = "The user is not a patient";
    }
  }
}
 
echo json_encode($response);
?>