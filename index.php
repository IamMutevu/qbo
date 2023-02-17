<?php

require 'vendor/autoload.php';
require 'classes/Quickbooks.php';
require 'classes/Authentication.php';



// Get parameters of incoming requests
if (!empty($_POST)) {
    $params = $_POST;

} elseif (!empty($_GET)) {
    $params = $_GET;
} else {
    $params = json_decode(file_get_contents("php://input"), true);
}

$qbo = new Quickbooks();
// echo $qbo->getAuthUrl();

if(isset($params['code']) && isset($params['realmId'])){
    Authentication::getAccessToken($params['code'], $params['realmId'], '276');
}