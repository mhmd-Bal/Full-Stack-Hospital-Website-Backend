<?php
include('connection.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

$service_id = $_POST['service_id'];
$status = "Declined";

$check_service = $mysqli->prepare('select id from services where id=?');
$check_service->bind_param('i', $service_id);
$check_service->execute();
$check_service->store_result();

$service_doesnt_exist = $check_service->num_rows();
$response = [];

if ($service_doesnt_exist == 0) {
  $response['response'] = "Service not found";
} else {
  $check_user = $mysqli->prepare('update services set status=? where id=?');
  $check_user->bind_param('si', $status, $service_id);
  $check_user->execute();
  $response['response'] = "Service Declined!";
}
 
echo json_encode($response);
?>