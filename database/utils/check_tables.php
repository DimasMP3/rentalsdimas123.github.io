<?php
$conn = new mysqli('localhost', 'root', '', 'rentalmobil');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$tables = ['users', 'categories', 'cars', 'orders', 'payments'];

foreach ($tables as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result->num_rows > 0) {
        echo "Tabel '$table' berhasil dibuat\n";
    } else {
        echo "Tabel '$table' tidak ditemukan\n";
    }
}

$conn->close();
?> 