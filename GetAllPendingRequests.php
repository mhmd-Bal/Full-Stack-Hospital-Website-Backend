<?php
include ('connection.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

$query = $mysqli->prepare("select services.id, services.patient_id, users.user_name, services.employee_id, services.department_id, departments.name, services.description, services.cost
from services 
inner join departments on services.department_id = departments.id
inner join users on services.patient_id = users.id
where services.status = 'Pending'
");
$query -> execute();
$result = $query->get_result();

$pending_requests = [];
while ($row = $result->fetch_assoc()){
  $pending_requests[] = $row;
}

echo json_encode($pending_requests);