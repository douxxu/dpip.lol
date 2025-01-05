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
        throw new Exception('Error while connecting to db.');
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

    $deleteEmailQuery = $mysqli->prepare("DELETE FROM emails WHERE email = ?");
    $deleteEmailQuery->bind_param("s", $email);

    if (!$deleteEmailQuery->execute()) {
        throw new Exception('Error while deleting the email.');
    }

    if ($deleteEmailQuery->affected_rows > 0) {
        include 'success.html';
    } else {
        include 'error.html';
    }

    $deleteEmailQuery->close();
    $mysqli->close();

} catch (Exception $e) {
    error_log($e->getMessage());
    include 'error.html';
    exit();
}
