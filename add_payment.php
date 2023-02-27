<?php

include 'session_head.php';

$payment = array(
    'customer_id' => $_POST['client_id'],
    'amount' => $_POST['amount'],
    'pay_date' => $_POST['pay_date'],
);


$connection = DatabaseConnection::connect();
$query = $connection->prepare("INSERT INTO `payments`(amount, pay_date, client_id, created_at, updated_at, timestamp) VALUES(?, ?, ?, ?, ?, ?)");
$query->execute(array($payment['amount'], $payment['pay_date'], $payment['customer_id'], date("d-m-Y H:i"), date("d-m-Y H:i"), time()));
$connection = null;

if($query){
    header('Location: dashboard.php?success=Payment added successfully');
}