<a?php

// Database connection details
$host = 'localhost';
$user = 'root';
$pass = '';
$database = 'rentals';

// Create connection
$conn = new mysqli($host, $user, $pass, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to add columns
$sql = "ALTER TABLE payments 
        ADD COLUMN IF NOT EXISTS bank_name VARCHAR(50) NULL AFTER payment_method,
        ADD COLUMN IF NOT EXISTS ewallet_provider VARCHAR(50) NULL AFTER bank_name,
        ADD COLUMN IF NOT EXISTS paylater_provider VARCHAR(50) NULL AFTER ewallet_provider,
        ADD COLUMN IF NOT EXISTS minimarket_provider VARCHAR(50) NULL AFTER paylater_provider";

// Execute query
if ($conn->query($sql) === TRUE) {
    echo "Columns added successfully";
} else {
    echo "Error adding columns: " . $conn->error;
}

$conn->close();
echo "\nDone."; 