<?php
include('connection.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

$patients = 1;
$employees = 2;


$check_patients = $mysqli->prepare('select id from users where usertype_id=?');
$check_patients->bind_param('i', $patients);
$check_patients->execute();
$check_patients->store_result();
$patients_number = $check_patients->num_rows();

$check_employees = $mysqli->prepare('select id from users where usertype_id=?');
$check_employees->bind_param('i', $employees);
$check_employees->execute();
$check_employees->store_result();
$employees_number = $check_employees->num_rows();

$check_hospitals = $mysqli->prepare('select id from hospitals');
$check_hospitals->execute();
$check_hospitals->store_result();
$hospitals_number = $check_hospitals->num_rows();

$response = [];
$response['patients_number'] = $patients_number;
$response['employees_number'] = $employees_number;
$response['hospitals_number'] = $hospitals_number;

echo json_encode($response);
?>