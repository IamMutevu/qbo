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

$qbo->addCustomer($customer);