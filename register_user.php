<?php
require_once 'qbo/classes/DatabaseConnection.php';

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

try {
    $connection = DatabaseConnection::connect();
    $query = $connection->prepare("INSERT INTO `users`(name, email, password, created_at, updated_at) VALUES(?, ?, ?, ?, ?)");
    $query->execute(array($name, $email, $hashed_password, date("d-m-Y H:i"), date("d-m-Y H:i")));
    $connection = null;

    header('Location: login.php?success=Successfully registered. You can now log in');
} catch (PDOException $e) {
    header('Location: signup.php?error='.$e->getMessage());
    // echo $sql . "<br>" . $e->getMessage();
}
