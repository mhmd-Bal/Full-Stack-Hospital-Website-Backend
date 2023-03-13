<?php
include("Connection.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

$user_id = $_POST['user_id'];
$medication_id = $_POST['medication_id'];


$check_medication = $mysqli -> prepare('select quantity from medications where id=?');
$check_medication -> bind_param('i', $medication_id);
$check_medication -> execute();
$check_medication -> store_result();
$check_medication -> bind_result($quantity);
$check_medication -> fetch();
$medication_doesnt_exist = $check_medication->num_rows();


if($email_exists = 0){
  $response['response'] = "Medication Doesn't exist!";
}else if($quantity == 0){
  $response['response'] = "Medication Out of Stock!";
}else{
  $query = $mysqli -> prepare('insert into user_has_medications(user_id, medication_id) values(?,?)');
  $query -> bind_param('ii', $user_id, $medication_id);
  $query -> execute();

  $quantity -= 1;
  $substract_quantity = $mysqli -> prepare('update medications set quantity=? where id=?');
  $substract_quantity -> bind_param('ii', $quantity, $medication_id);
  $substract_quantity -> execute();

  $response['response'] = "Medication Bought!";
}

echo json_encode($response);
