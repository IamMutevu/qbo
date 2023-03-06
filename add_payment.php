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


if($query){
    // Get customer data from clients table
    $query = $connection->prepare("SELECT * FROM clients WHERE id = ?");
    $query->execute(array($payment['customer_id']));
    $client = $query->fetch(PDO::FETCH_OBJ);

    // echo json_encode($client);

    $customer = array(
        'id' => $client->id,
        'name' => $client->client_fname,
        'email' => $client->client_email,
        'phone' => $client->client_phone,
        'suffix' => '',
        'title' => '',
        'middle_name' => '',
        'notes' => '',
        'sur_name' => '',
        'country_code' => '',
        'city' => '',
        'postal_code' => '',
        'line' => '',
        'country' => '',
        'given_name' => '',
        'company_name' => '',
    );

    $data = array(
        "customer" => $customer,
        "payment" => $payment
    );

    // $qbo->addPayment($data);

    if($qbo->addPayment($data)){
        header('Location: dashboard.php?success=Payment added and linked successfully');
    }
    else{
        header('Location: dashboard.php?success=Payment added successfully');
    }
    
}