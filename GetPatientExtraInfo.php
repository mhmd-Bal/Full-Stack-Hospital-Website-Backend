<?php
include('connection.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

$user_id = $_POST['user_id'];

$query = $mysqli->prepare('select blood_type, EHR from patients_info where user_id=?');
$query->bind_param('i', $user_id);
$query->execute();
$query->store_result();
$query->bind_result($blood_type, $ehr);
$query->fetch();
$response = [];

$response['blood_type'] = $blood_type;
$response['ehr'] = $ehr;
 
echo json_encode($response);
?>