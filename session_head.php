<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$user_id = null;
$username = null;

if (array_key_exists('user_id', $_SESSION) && array_key_exists('name', $_SESSION)) {
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['name'];
}

if(!isset($user_id)){
    include 'login.php';
    exit;
}

include 'qbo/index.php';