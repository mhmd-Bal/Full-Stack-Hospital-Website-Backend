<?php
include ('connection.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");


$check_medications = $mysqli->prepare("select name, cost, quantity from medications");
$check_medications -> execute();
$medications_result = $check_medications->get_result();

$medication_items = [];
while ($row = $medications_result->fetch_assoc()){
  $medication_items[] = $row;
}


echo json_encode($medication_items);