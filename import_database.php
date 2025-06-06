<?php
// Koneksi ke MySQL
$conn = new mysqli('localhost', 'root', '');

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Hapus database jika sudah ada
$conn->query("DROP DATABASE IF EXISTS rentalmobil");
echo "Database lama dihapus (jika ada)\n";

// Buat database baru
if ($conn->query("CREATE DATABASE rentalmobil")) {
    echo "Database rentalmobil berhasil dibuat\n";
} else {
    die("Error creating database: " . $conn->error);
}

// Pilih database
$conn->select_db('rentalmobil');
echo "Database rentalmobil dipilih\n";

// Baca file SQL
$sql = file_get_contents('database.sql');

// Pisahkan query berdasarkan semicolon
$queries = array_filter(array_map('trim', explode(';', $sql)), 'strlen');

// Eksekusi setiap query
foreach ($queries as $query) {
    if ($conn->query($query)) {
        if (stripos($query, 'CREATE TABLE') !== false) {
            preg_match('/CREATE TABLE.*?(\w+)/i', $query, $matches);
            if (isset($matches[1])) {
                echo "Tabel {$matches[1]} berhasil dibuat\n";
            }
        }
    } else {
        echo "Error executing query: " . $conn->error . "\n";
        echo "Query: " . $query . "\n";
    }
}

$conn->close();
echo "Selesai!\n";
?> 