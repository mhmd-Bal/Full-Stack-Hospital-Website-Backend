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
  $check_user = $mysqli->prepare('select usertype_id from users where id=?');
  $check_user->bind_param('i', $user_id);
  $check_user->execute();
  $check_user->store_result();
  $check_user->bind_result($usertype_id);
  $check_user->fetch();
  $user_doesnt_exist = $check_user->num_rows();

  if($user_doesnt_exist == 0){
    $response['response'] = "User not found";
  }else{
    if($usertype_id == 2){
      $check_if_user_assigned = $mysqli->prepare('select is_active from hospital_users where user_id=? and hospital_id=?');
      $check_if_user_assigned->bind_param('ii', $user_id, $hospital_id);
      $check_if_user_assigned->execute();
      $check_if_user_assigned->store_result();
      $check_if_user_assigned->bind_result($already_active);
      $check_if_user_assigned->fetch();

      $user_already_assigned = $check_if_user_assigned->num_rows();
      if($user_already_assigned >= 1 && $already_active == 1) {
        $response['response'] = "The employee is already active in this hospital";
      }else{
        $query = $mysqli->prepare('insert into hospital_users(hospital_id, user_id, is_active, date_joined, date_left) values(?, ?, ?, ?, ?)');
        $query->bind_param('iiiss', $hospital_id, $user_id, $is_active, $date_joined, $date_left);
        $query->execute();
        $response['response'] = "Employee Assigned!";
      }

    }else{
      $response['response'] = "The user is not an employee";
    }
  }
}
 
echo json_encode($response);
?>