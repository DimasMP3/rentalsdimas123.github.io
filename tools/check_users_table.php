<?php

$conn = new mysqli('localhost', 'root', '', 'rentals');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Periksa apakah tabel users ada
$tableExists = $conn->query("SHOW TABLES LIKE 'users'")->num_rows > 0;
echo "Table 'users' exists: " . ($tableExists ? 'Yes' : 'No') . "\n";

if ($tableExists) {
    // Tampilkan struktur tabel users
    echo "\nTable structure for 'users':\n";
    $result = $conn->query("DESCRIBE users");
    while ($row = $result->fetch_assoc()) {
        echo $row['Field'] . ' - ' . $row['Type'] . ' - ' . ($row['Null'] == 'YES' ? 'NULL' : 'NOT NULL') . 
             ' - ' . ($row['Key'] == 'PRI' ? 'PRIMARY KEY' : $row['Key']) . "\n";
    }
    
    // Tampilkan contoh data user (jangan tampilkan password)
    echo "\nSample users data (first 5 rows):\n";
    $result = $conn->query("SELECT id, name, email, role, status FROM users LIMIT 5");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "ID: " . $row['id'] . " - Name: " . $row['name'] . " - Email: " . $row['email'] . 
                 " - Role: " . $row['role'] . " - Status: " . $row['status'] . "\n";
        }
    } else {
        echo "No users found in the database.\n";
    }
} else {
    // Struktur tabel yang seharusnya ada
    echo "\nExpected table structure:\n";
    echo "id - INT(11) UNSIGNED - NOT NULL - PRIMARY KEY\n";
    echo "name - VARCHAR(100) - NOT NULL\n";
    echo "email - VARCHAR(100) - NOT NULL - UNIQUE\n";
    echo "password - VARCHAR(255) - NOT NULL\n";
    echo "phone - VARCHAR(20) - NULL\n";
    echo "address - TEXT - NULL\n";
    echo "role - ENUM('admin','user') - NOT NULL - DEFAULT 'user'\n";
    echo "status - VARCHAR(10) - NOT NULL - DEFAULT 'active'\n";
    echo "created_at - DATETIME - NULL\n";
    echo "updated_at - DATETIME - NULL\n";
}

$conn->close(); 