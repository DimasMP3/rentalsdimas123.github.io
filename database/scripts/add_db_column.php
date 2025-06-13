<?php
// Direct database connection script

// Database credentials - update these to match your environment
$host = 'localhost';
$dbname = 'rentals';
$username = 'root';
$password = '';

try {
    // Connect to the database
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set PDO to throw exceptions on error
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Execute the SQL query
    $sql = "ALTER TABLE orders ADD COLUMN attachment VARCHAR(255) NULL AFTER payment_proof";
    $db->exec($sql);
    
    echo "Column 'attachment' added successfully!";
} catch(PDOException $e) {
    echo "Database Error: " . $e->getMessage();
}
?> 