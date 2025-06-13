<?php
// Koneksi langsung ke database rentalmobil
$conn = new mysqli('localhost', 'root', '', 'rentalmobil');

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error . "\n");
}
echo "Terhubung ke database\n";

// Drop tabel jika ada (dalam urutan terbalik karena foreign key)
$conn->query("SET FOREIGN_KEY_CHECKS = 0");
$conn->query("DROP TABLE IF EXISTS payments");
$conn->query("DROP TABLE IF EXISTS orders");
$conn->query("DROP TABLE IF EXISTS cars");
$conn->query("DROP TABLE IF EXISTS categories");
$conn->query("DROP TABLE IF EXISTS users");
$conn->query("SET FOREIGN_KEY_CHECKS = 1");
echo "Tabel lama dihapus\n";

// Buat tabel users
$sql_users = "CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    license_number VARCHAR(50),
    role ENUM('admin', 'user') DEFAULT 'user',
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql_users)) {
    echo "Tabel users dibuat\n";
} else {
    die("Error membuat tabel users: " . $conn->error . "\n");
}

// Buat tabel categories
$sql_categories = "CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql_categories)) {
    echo "Tabel categories dibuat\n";
} else {
    die("Error membuat tabel categories: " . $conn->error . "\n");
}

// Buat tabel cars
$sql_cars = "CREATE TABLE cars (
    id INT PRIMARY KEY AUTO_INCREMENT,
    category_id INT,
    brand VARCHAR(100) NOT NULL,
    model VARCHAR(100) NOT NULL,
    year INT,
    license_plate VARCHAR(20) NOT NULL,
    color VARCHAR(50),
    price_per_day DECIMAL(10,2) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    status ENUM('available', 'rented', 'maintenance') DEFAULT 'available',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
)";

if ($conn->query($sql_cars)) {
    echo "Tabel cars dibuat\n";
} else {
    die("Error membuat tabel cars: " . $conn->error . "\n");
}

// Buat tabel orders
$sql_orders = "CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    car_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'approved', 'completed', 'cancelled') DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (car_id) REFERENCES cars(id)
)";

if ($conn->query($sql_orders)) {
    echo "Tabel orders dibuat\n";
} else {
    die("Error membuat tabel orders: " . $conn->error . "\n");
}

// Buat tabel payments
$sql_payments = "CREATE TABLE payments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_method ENUM('transfer', 'cash') NOT NULL,
    payment_proof VARCHAR(255),
    status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    payment_date DATETIME,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id)
)";

if ($conn->query($sql_payments)) {
    echo "Tabel payments dibuat\n";
} else {
    die("Error membuat tabel payments: " . $conn->error . "\n");
}

// Insert admin user
$sql_admin = "INSERT INTO users (name, email, password, role) VALUES 
('Admin', 'admin@admin.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin')";

if ($conn->query($sql_admin)) {
    echo "Admin user dibuat\n";
} else {
    die("Error membuat admin user: " . $conn->error . "\n");
}

// Insert sample categories
$sql_sample_categories = "INSERT INTO categories (name, description) VALUES
('SUV', 'Sport Utility Vehicle dengan kapasitas besar'),
('Sedan', 'Mobil penumpang dengan kenyamanan premium'),
('MPV', 'Multi Purpose Vehicle untuk keluarga'),
('Hatchback', 'Mobil kompak untuk perkotaan')";

if ($conn->query($sql_sample_categories)) {
    echo "Sample categories ditambahkan\n";
} else {
    die("Error menambahkan sample categories: " . $conn->error . "\n");
}

// Insert sample cars
$sql_sample_cars = "INSERT INTO cars (category_id, brand, model, year, license_plate, color, price_per_day, description, status) VALUES
(1, 'Toyota', 'Rush', 2022, 'B 1234 ABC', 'Putih', 500000, 'SUV 7 seater nyaman', 'available'),
(1, 'Honda', 'CR-V', 2021, 'B 2345 BCD', 'Hitam', 600000, 'SUV premium dengan teknologi hybrid', 'available'),
(2, 'Toyota', 'Camry', 2022, 'B 3456 CDE', 'Silver', 800000, 'Sedan mewah dengan interior premium', 'available'),
(3, 'Toyota', 'Avanza', 2022, 'B 4567 DEF', 'Putih', 350000, 'MPV keluarga yang ekonomis', 'available'),
(3, 'Mitsubishi', 'Xpander', 2022, 'B 5678 EFG', 'Abu-abu', 400000, 'MPV modern dengan desain futuristik', 'available'),
(4, 'Honda', 'Brio', 2022, 'B 6789 FGH', 'Merah', 300000, 'City car lincah dan irit', 'available')";

if ($conn->query($sql_sample_cars)) {
    echo "Sample cars ditambahkan\n";
} else {
    die("Error menambahkan sample cars: " . $conn->error . "\n");
}

// Verifikasi semua tabel
$tables = ['users', 'categories', 'cars', 'orders', 'payments'];
echo "\nVerifikasi tabel:\n";

foreach ($tables as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result->num_rows > 0) {
        $count = $conn->query("SELECT COUNT(*) as count FROM $table")->fetch_assoc()['count'];
        echo "- Tabel '$table' ada dengan $count data\n";
    } else {
        echo "- Tabel '$table' tidak ditemukan\n";
    }
}

$conn->close();
echo "\nProses selesai!\n";
?> 