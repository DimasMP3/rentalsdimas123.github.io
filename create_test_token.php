<?php

// Connect to database
$conn = new mysqli('localhost', 'root', '', 'rentals');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Generate token
$email = 'admin@gmail.com';
$token = bin2hex(random_bytes(32));
$created = date('Y-m-d H:i:s');
$expires = date('Y-m-d H:i:s', time() + 3600); // 1 hour

// Check if table exists
$tableExists = $conn->query("SHOW TABLES LIKE 'password_reset_tokens'")->num_rows > 0;
echo "Table 'password_reset_tokens' exists: " . ($tableExists ? 'Yes' : 'No') . "\n";

if (!$tableExists) {
    // Create table if not exists
    $sql = "CREATE TABLE IF NOT EXISTS password_reset_tokens (
        id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        email VARCHAR(255) NOT NULL,
        token VARCHAR(64) NOT NULL,
        created_at DATETIME NOT NULL,
        expires_at DATETIME NOT NULL,
        PRIMARY KEY (id),
        KEY email (email),
        KEY token (token)
    )";
    
    if ($conn->query($sql)) {
        echo "Table 'password_reset_tokens' created successfully.\n";
    } else {
        echo "Error creating table: " . $conn->error . "\n";
        exit;
    }
}

// Delete any existing token for this email
$conn->query("DELETE FROM password_reset_tokens WHERE email = '$email'");

// Insert new token
$sql = "INSERT INTO password_reset_tokens (email, token, created_at, expires_at) 
        VALUES ('$email', '$token', '$created', '$expires')";

if ($conn->query($sql)) {
    echo "Token created successfully!\n";
    echo "Email: $email\n";
    echo "Token: $token\n";
    echo "Created at: $created\n";
    echo "Expires at: $expires\n";
    
    echo "\nReset link: " . "http://localhost/rentalmobil/reset-password/$token" . "\n";
} else {
    echo "Error creating token: " . $conn->error . "\n";
}

$conn->close(); 