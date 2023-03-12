<?php
include ('connection.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

$query = $mysqli->prepare("select hospital_users.id, hospital_users.user_id, users.user_name, hospital_users.hospital_id, hospitals.hospital_name, hospital_users.date_joined, hospital_users.date_left, hospital_users.is_active
from hospital_users 
inner join hospitals on hospital_users.hospital_id = hospitals.id
inner join users on hospital_users.user_id = users.id
where users.usertype_id = 2
");
$query -> execute();
$result = $query->get_result();

$patients_in_hospitals = [];
while ($row = $result->fetch_assoc()){
  $patients_in_hospitals[] = $row;
}

echo json_encode($patients_in_hospitals);