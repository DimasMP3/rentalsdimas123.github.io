<?php

// Database konfigurasi
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'rentals';

// Buat koneksi
$conn = new mysqli($hostname, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// SQL query untuk menambahkan data mobil
$sql = "
-- Menambahkan data mobil dengan harga dalam Rupiah
INSERT INTO cars (category_id, brand, model, year, license_plate, color, daily_rate, description, status) VALUES
-- SUV
(1, 'Toyota', 'Fortuner', 2023, 'B 1122 FOR', 'Hitam', 1250000.00, 'SUV premium dengan mesin tangguh dan interior mewah', 'available'),
(1, 'Mitsubishi', 'Pajero Sport', 2023, 'B 2233 PAJ', 'Putih', 1200000.00, 'SUV tangguh dengan desain agresif dan fitur keselamatan lengkap', 'available'),
(1, 'Honda', 'CR-V Turbo', 2023, 'B 3344 CRV', 'Abu Metalik', 950000.00, 'SUV kompak dengan teknologi turbo dan kenyamanan premium', 'available'),

-- Sedan
(2, 'Toyota', 'Corolla Altis', 2023, 'B 4455 ALT', 'Silver', 750000.00, 'Sedan elegan dengan teknologi hybrid dan fitur keselamatan lengkap', 'available'),
(2, 'Honda', 'Civic RS', 2023, 'B 5566 CVC', 'Merah', 850000.00, 'Sedan sporty dengan performa tinggi dan teknologi canggih', 'available'),
(2, 'BMW', '320i', 2022, 'B 6677 BMW', 'Hitam', 2500000.00, 'Sedan premium dengan kemewahan khas Jerman dan performa dinamis', 'available'),

-- MPV
(3, 'Toyota', 'Alphard', 2023, 'B 7788 ALP', 'Putih', 3500000.00, 'MPV mewah dengan kabin luas dan fitur premium', 'available'),
(3, 'Kia', 'Carnival', 2023, 'B 8899 KIA', 'Hitam', 2200000.00, 'MPV premium dengan desain modern dan kenyamanan terbaik', 'available'),
(3, 'Toyota', 'Innova Zenix', 2023, 'B 9900 INV', 'Silver', 950000.00, 'MPV keluarga dengan kombinasi kenyamanan dan efisiensi bahan bakar', 'available'),

-- Hatchback
(4, 'Honda', 'City Hatchback', 2023, 'B 1010 CTY', 'Biru', 650000.00, 'Hatchback bergaya dengan ruang kabin luas dan performa menyenangkan', 'available')
";

// Jalankan query
if ($conn->multi_query($sql)) {
    $count = 0;
    do {
        // Count berapa baris yang terpengaruh
        if ($result = $conn->store_result()) {
            $result->free();
        }
        $count++;
    } while ($conn->next_result());
    
    echo "Berhasil! Data mobil baru telah ditambahkan ke database.\n";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Tutup koneksi
$conn->close(); 