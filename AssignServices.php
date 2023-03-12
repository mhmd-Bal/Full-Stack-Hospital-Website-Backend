<?php
include('connection.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

$patient_id = $_POST['patient_id'];
$description = $_POST['description'];
$cost = $_POST['cost'];
$department_id = $_POST['department_id'];
$employee_id = $_POST['employee_id'];
$status = $_POST['status'];

$check_department = $mysqli->prepare('select id from departments where id=?');
$check_department->bind_param('i', $department_id);
$check_department->execute();
$check_department->store_result();

$department_doesnt_exist = $check_department->num_rows();
$response = [];

if ($department_doesnt_exist == 0) {
  $response['response'] = "Department not found";
} else {
  $check_user = $mysqli->prepare('select usertype_id from users where id=?');
  $check_user->bind_param('i', $patient_id);
  $check_user->execute();
  $check_user->store_result();
  $check_user->bind_result($usertype_id);
  $check_user->fetch();
  $user_doesnt_exist = $check_user->num_rows();

  if($user_doesnt_exist == 0){
    $response['response'] = "User not found";
  }else{
    if($usertype_id == 1){
      $query = $mysqli->prepare('insert into services(patient_id, employee_id, description, cost, department_id, status) values(?, ?, ?, ?, ?, ?)');
      $query->bind_param('iisiis', $patient_id, $employee_id, $description, $cost, $department_id, $status);
      $query->execute();
      $response['response'] = "Service Assigned!";
    }else{
      $response['response'] = "The user is not a patient";
    }
  }
}
 
echo json_encode($response);
?>