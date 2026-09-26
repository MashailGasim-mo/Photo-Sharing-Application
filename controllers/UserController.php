<?php

require_once DIR . '/../Core/Database.php';
require_once DIR . '/../Models/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {

    $database = new Database();
    $connection = $database->getConnection();

    $user = new User($connection);

    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $location = $_POST['location'] ?? null;
    $description = $_POST['description'] ?? null;
    $occupation = $_POST['occupation'] ?? null;

    if ($user->findByEmail($email)) {
        die("Email already exists.");
    }

    if ($user->create(
        $firstName,
        $lastName,
        $email,
        $password,
        $location,
        $description,
        $occupation
    )) {
        echo "Registration successful!";
    } else {
        echo "Registration failed.";
    }
}