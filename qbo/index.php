<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';
require 'classes/Authentication.php';
require 'classes/Quickbooks.php';


use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\Facades\Customer;

// Get parameters of incoming requests
if (!empty($_POST)) {
    $params = $_POST;

} elseif (!empty($_GET)) {
    $params = $_GET;
} else {
    $params = json_decode(file_get_contents("php://input"), true);
}

$qbo = new Quickbooks();

try {
    if(isset($params['code']) && isset($params['realmId'])){
        Authentication::getAccessToken($params['code'], $params['realmId'], $user_id);
    }
} 
catch (Exception $e) {
    error_log($e->getMessage());
    exit;
}
