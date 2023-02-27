<?php

include 'session_head.php';

$customer = array(
    'name' => $_POST['name'],
    'email' => $_POST['email'],
    'phone' => $_POST['phone'],
    'suffix' => $_POST['title'],
    'title' => $_POST['title'],
    'middle_name' => $_POST['name'],
    'notes' => '',
    'sur_name' => $_POST['name'],
    'country_code' => $_POST['country_code'],
    'city' => $_POST['city'],
    'postal_code' => $_POST['postal_code'],
    'line' => $_POST['street'],
    'country' => $_POST['country'],
    'given_name' => '',
    'company_name' => '',
);

// $qbo->addCustomer($customer);

$connection = DatabaseConnection::connect();
$query = $connection->prepare("INSERT INTO `clients`(client_fname, client_phone, client_email, client_city, client_postal_code, client_street, created_at, updated_at, timestamp) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
$query->execute(array($customer['name'], $customer['phone'], $customer['email'], $customer['city'], $customer['postal_code'], $customer['line'], date("d-m-Y H:i"), date("d-m-Y H:i"), time()));
$connection = null;

if($query){
    header('Location: dashboard.php?success=Customer added successfully');
}