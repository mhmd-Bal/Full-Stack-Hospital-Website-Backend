<?php
include('connection.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

$ssn = $_POST['ssn'];
$date_joined = $_POST['date_joined'];
$position = $_POST['position'];
$user_id = $_POST['user_id'];


$check_user_info = $mysqli->prepare('select id from employees_info where user_id=?');
$check_user_info->bind_param('i', $user_id);
$check_user_info->execute();
$check_user_info->store_result();

$user_info_exists = $check_user_info->num_rows();
$response = [];

if ($user_info_exists > 0) {
  $query = $mysqli->prepare('update employees_info set SSN=?, date_joined=?, position=? where user_id=?');
  $query -> bind_param('issi', $ssn, $date_joined, $position, $user_id);
  $query -> execute();
  $response['response'] = "Employee Info Updated!";
}else{
  $query = $mysqli->prepare('insert into employees_info(user_id, SSN, date_joined, position) values(?, ?, ?, ?)');
  $query -> bind_param('iiss', $user_id, $ssn, $date_joined, $position);
  $query -> execute();
  $response['response'] = "Employee Info Added!";
}
 
echo json_encode($response);
?>