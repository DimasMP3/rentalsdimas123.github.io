<?php
// Koneksi database
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'rentals';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Cek apakah kolom sudah ada
$result = $conn->query("SHOW COLUMNS FROM reviews LIKE 'is_approved'");
$exists = ($result->num_rows > 0);

if (!$exists) {
    // Tambahkan kolom is_approved
    $sql = "ALTER TABLE reviews ADD COLUMN is_approved TINYINT(1) DEFAULT 0 AFTER comment";
    
    if ($conn->query($sql) === TRUE) {
        echo "Kolom is_approved berhasil ditambahkan ke tabel reviews.";
    } else {
        echo "Error menambahkan kolom: " . $conn->error;
    }
} else {
    echo "Kolom is_approved sudah ada di tabel reviews.";
}

$conn->close(); 