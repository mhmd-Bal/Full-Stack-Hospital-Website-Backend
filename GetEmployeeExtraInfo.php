<?php
include('connection.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

$user_id = $_POST['user_id'];

$query = $mysqli->prepare('select SSN, date_joined, position from employees_info where user_id=?');
$query->bind_param('i', $user_id);
$query->execute();
$query->store_result();
$query->bind_result($ssn, $date_joined, $position);
$query->fetch();
$response = [];

$response['ssn'] = $ssn;
$response['date_joined'] = $date_joined;
$response['position'] = $position;
 
echo json_encode($response);
?>