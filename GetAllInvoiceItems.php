<?php
include ('connection.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

$user_id = $_POST['user_id'];
$status = 'Approved';

$check_medications = $mysqli->prepare("select medications.name, medications.cost
from user_has_medications
inner join users on user_has_medications.user_id = users.id
inner join medications on user_has_medications.medication_id = medications.id
where users.id =?
");
$check_medications -> bind_param('i',$user_id);
$check_medications -> execute();
$medications_result = $check_medications->get_result();

$invoice_items = [];
while ($row = $medications_result->fetch_assoc()){
  $invoice_items[] = $row;
}


$check_services = $mysqli -> prepare("select description, cost from services where patient_id =? and status=?");
$check_services -> bind_param('is', $user_id, $status);
$check_services -> execute();
$services_result = $check_services->get_result();

while ($row = $services_result->fetch_assoc()){
  $invoice_items[] = $row;
}

echo json_encode($invoice_items);