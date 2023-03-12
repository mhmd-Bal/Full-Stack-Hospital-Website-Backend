<?php
include('connection.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

$blood_type = $_POST['blood_type'];
$ehr = $_POST['ehr'];
$user_id = $_POST['user_id'];


$check_user_info = $mysqli->prepare('select id from patients_info where user_id=?');
$check_user_info->bind_param('i', $user_id);
$check_user_info->execute();
$check_user_info->store_result();

$user_info_exists = $check_user_info->num_rows();
$response = [];

if ($user_info_exists > 0) {
  $query = $mysqli->prepare('update patients_info set blood_type=?, EHR=? where user_id=?');
  $query -> bind_param('ssi', $blood_type, $ehr, $user_id);
  $query -> execute();
  $response['response'] = "Patient Info Updated!";
}else{
  $query = $mysqli->prepare('insert into patients_info(user_id, blood_type, EHR) values(?, ?, ?)');
  $query -> bind_param('iss', $user_id, $blood_type, $ehr);
  $query -> execute();
  $response['response'] = "Patient Info Added!";
}
 
echo json_encode($response);
?>