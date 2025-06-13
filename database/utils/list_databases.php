<?php
// Direct database connection script

// Database credentials - update these to match your environment
$host = 'localhost';
$username = 'root';
$password = '';

try {
    // Connect to the server without specifying a database
    $db = new PDO("mysql:host=$host", $username, $password);
    
    // Set PDO to throw exceptions on error
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get list of databases
    $stmt = $db->query('SHOW DATABASES');
    $databases = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "Available databases:<br>";
    foreach ($databases as $database) {
        echo "- $database<br>";
    }
} catch(PDOException $e) {
    echo "Database Error: " . $e->getMessage();
}
?> 