USE rentalmobil;

-- Insert sample categories
INSERT INTO categories (name, description) VALUES
('SUV', 'Sport Utility Vehicle dengan kapasitas besar'),
('Sedan', 'Mobil penumpang dengan kenyamanan premium'),
('MPV', 'Multi Purpose Vehicle untuk keluarga'),
('Hatchback', 'Mobil kompak untuk perkotaan');

-- Insert sample cars
INSERT INTO cars (category_id, brand, model, year, license_plate, color, price_per_day, description, status) VALUES
(1, 'Toyota', 'Rush', 2022, 'B 1234 ABC', 'Putih', 500000, 'SUV 7 seater nyaman', 'available'),
(1, 'Honda', 'CR-V', 2021, 'B 2345 BCD', 'Hitam', 600000, 'SUV premium dengan teknologi hybrid', 'available'),
(2, 'Toyota', 'Camry', 2022, 'B 3456 CDE', 'Silver', 800000, 'Sedan mewah dengan interior premium', 'available'),
(3, 'Toyota', 'Avanza', 2022, 'B 4567 DEF', 'Putih', 350000, 'MPV keluarga yang ekonomis', 'available'),
(3, 'Mitsubishi', 'Xpander', 2022, 'B 5678 EFG', 'Abu-abu', 400000, 'MPV modern dengan desain futuristik', 'available'),
(4, 'Honda', 'Brio', 2022, 'B 6789 FGH', 'Merah', 300000, 'City car lincah dan irit', 'available'); 