<?php

// Load the CodeIgniter instance
require 'vendor/autoload.php';

// Get CodeIgniter instance
$app = require FCPATH . '../app/Config/Paths.php';
$paths = new Config\Paths();

// Use CodeIgniter's database connection
$db = \Config\Database::connect();

try {
    // Execute the SQL query
    $db->query("ALTER TABLE orders ADD COLUMN attachment VARCHAR(255) NULL AFTER payment_proof");
    echo "Column 'attachment' added successfully to orders table!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} 