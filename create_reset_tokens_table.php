<?php

$conn = new mysqli('localhost', 'root', '', 'rentals');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$sql = 'CREATE TABLE IF NOT EXISTS password_reset_tokens (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    token VARCHAR(64) NOT NULL,
    created_at DATETIME NOT NULL,
    expires_at DATETIME NOT NULL,
    PRIMARY KEY (id),
    KEY email (email),
    KEY token (token)
)';

if ($conn->query($sql) === TRUE) {
    echo 'Table password_reset_tokens created successfully';
} else {
    echo 'Error creating table: ' . $conn->error;
}

$conn->close(); 