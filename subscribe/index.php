<?php
require_once '../utils/secrets.php';

if (!isset($_GET['email']) || empty($_GET['email'])) {
    include 'error.html';
    exit();
}

$email = $_GET['email'];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    include 'error.html';
    exit();
}

try {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($mysqli->connect_error) {
        throw new Exception('Failed to connect to the db.');
    }

    $createTableQuery = "
        CREATE TABLE IF NOT EXISTS emails (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) UNIQUE NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ";
    if (!$mysqli->query($createTableQuery)) {
        throw new Exception('Error while creating the table.');
    }

    $insertEmailQuery = $mysqli->prepare("INSERT INTO emails (email) VALUES (?)");
    $insertEmailQuery->bind_param("s", $email);

    if (!$insertEmailQuery->execute()) {
        throw new Exception('Error while inserting the email.');
    }

    $insertEmailQuery->close();
    $mysqli->close();

    include 'success.html';
    exit();

} catch (Exception $e) {
    error_log($e->getMessage());
    include 'error.html';
    exit();
}
