SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS payments;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS cars;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;

SET FOREIGN_KEY_CHECKS = 1;

-- Tabel users
CREATE TABLE users (
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
);

-- Tabel categories
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel cars
CREATE TABLE cars (
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
);

-- Tabel orders
CREATE TABLE orders (
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
);

-- Tabel payments
CREATE TABLE payments (
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
);

-- Insert sample data
INSERT INTO users (name, email, password, role) VALUES 
('Admin', 'admin@admin.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

INSERT INTO categories (name, description) VALUES
('SUV', 'Sport Utility Vehicle dengan kapasitas besar'),
('Sedan', 'Mobil penumpang dengan kenyamanan premium'),
('MPV', 'Multi Purpose Vehicle untuk keluarga'),
('Hatchback', 'Mobil kompak untuk perkotaan');

INSERT INTO cars (category_id, brand, model, year, license_plate, color, price_per_day, description, status) VALUES
(1, 'Toyota', 'Rush', 2022, 'B 1234 ABC', 'Putih', 500000, 'SUV 7 seater nyaman', 'available'),
(1, 'Honda', 'CR-V', 2021, 'B 2345 BCD', 'Hitam', 600000, 'SUV premium dengan teknologi hybrid', 'available'),
(2, 'Toyota', 'Camry', 2022, 'B 3456 CDE', 'Silver', 800000, 'Sedan mewah dengan interior premium', 'available'),
(3, 'Toyota', 'Avanza', 2022, 'B 4567 DEF', 'Putih', 350000, 'MPV keluarga yang ekonomis', 'available'),
(3, 'Mitsubishi', 'Xpander', 2022, 'B 5678 EFG', 'Abu-abu', 400000, 'MPV modern dengan desain futuristik', 'available'),
(4, 'Honda', 'Brio', 2022, 'B 6789 FGH', 'Merah', 300000, 'City car lincah dan irit', 'available'); 