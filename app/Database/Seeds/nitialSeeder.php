<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialSeeder extends Seeder
{
    public function run()
    {
        // Seed categories
        $categories = [
            [
                'name' => 'Economy',
                'description' => 'Affordable and fuel-efficient cars for budget-conscious travelers.'
            ],
            [
                'name' => 'Compact',
                'description' => 'Small cars that are easy to maneuver and park in urban areas.'
            ],
            [
                'name' => 'Sedan',
                'description' => 'Comfortable mid-size cars suitable for families and business trips.'
            ],
            [
                'name' => 'SUV',
                'description' => 'Spacious vehicles with higher ground clearance for all terrains.'
            ],
            [
                'name' => 'Luxury',
                'description' => 'Premium vehicles with high-end features and superior comfort.'
            ]
        ];
        
        foreach ($categories as $category) {
            $this->db->table('categories')->insert($category);
        }
        
        // Seed admin user
        $this->db->table('users')->insert([
            'name' => 'Admin User',
            'email' => 'admin@carrent.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'phone' => '1234567890',
            'address' => 'Admin Address',
            'license_number' => 'ADMIN123',
            'role' => 'admin'
        ]);
        
        // Seed sample cars
        $cars = [
            [
                'brand' => 'Toyota',
                'model' => 'Corolla',
                'year' => '2022',
                'license_plate' => 'ABC123',
                'daily_rate' => 50.00,
                'description' => 'Reliable and fuel-efficient sedan.',
                'image' => 'corolla.jpg',
                'status' => 'available',
                'category_id' => 3
            ],
            [
                'brand' => 'Honda',
                'model' => 'Civic',
                'year' => '2021',
                'license_plate' => 'DEF456',
                'daily_rate' => 45.00,
                'description' => 'Sporty and comfortable compact car.',
                'image' => 'civic.jpg',
                'status' => 'available',
                'category_id' => 2
            ],
            [
                'brand' => 'Ford',
                'model' => 'Explorer',
                'year' => '2022',
                'license_plate' => 'GHI789',
                'daily_rate' => 85.00,
                'description' => 'Spacious SUV with advanced safety features.',
                'image' => 'explorer.jpg',
                'status' => 'available',
                'category_id' => 4
            ],
            [
                'brand' => 'BMW',
                'model' => '5 Series',
                'year' => '2022',
                'license_plate' => 'JKL012',
                'daily_rate' => 120.00,
                'description' => 'Luxury sedan with premium features.',
                'image' => 'bmw5.jpg',
                'status' => 'available',
                'category_id' => 5
            ],
            [
                'brand' => 'Nissan',
                'model' => 'Versa',
                'year' => '2021',
                'license_plate' => 'MNO345',
                'daily_rate' => 35.00,
                'description' => 'Economical and practical small car.',
                'image' => 'versa.jpg',
                'status' => 'available',
                'category_id' => 1
            ]
        ];
        
        foreach ($cars as $car) {
            $this->db->table('cars')->insert($car);
        }
    }
}

