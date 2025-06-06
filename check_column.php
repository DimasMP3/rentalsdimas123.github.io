<?php
// Script to check if the attachment column exists in the orders table

// Database credentials
$host = 'localhost';
$dbname = 'rentals';
$username = 'root';
$password = '';

try {
    // Connect to the database
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set PDO to throw exceptions on error
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if column exists
    $stmt = $db->query("SHOW COLUMNS FROM orders LIKE 'attachment'");
    $columnExists = $stmt->fetchColumn() !== false;
    
    if ($columnExists) {
        echo "Success: The 'attachment' column exists in the orders table.";
    } else {
        echo "Warning: The 'attachment' column does NOT exist in the orders table.";
    }
    
    // Also show the structure of the orders table
    echo "\n\nTable Structure:\n";
    $stmt = $db->query("DESCRIBE orders");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['Field'] . " - " . $row['Type'] . "\n";
    }
    
} catch(PDOException $e) {
    echo "Database Error: " . $e->getMessage();
}
?> 