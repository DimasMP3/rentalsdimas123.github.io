<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class InsertSampleDiscounts extends BaseCommand
{
    protected $group = 'Database';
    protected $name = 'insert:sample_discounts';
    protected $description = 'Inserts sample discount data into the car_discounts table';

    public function run(array $params)
    {
        // Get the database connection
        $db = \Config\Database::connect();
        
        // Check if we have any cars in the database
        $carsResult = $db->query("SELECT id FROM cars LIMIT 3");
        $cars = $carsResult->getResultArray();
        
        if (empty($cars)) {
            CLI::error('No cars found in the database. Please add some cars first.');
            return;
        }
        
        // Get the IDs of the first three cars
        $carIds = array_column($cars, 'id');
        
        try {
            // Clear any existing sample data
            $db->query("DELETE FROM car_discounts WHERE car_id IN (" . implode(',', $carIds) . ")");
            
            // Insert sample data
            if (isset($carIds[0])) {
                // Car 1 has discounts on Monday and Friday
                $db->query("INSERT INTO car_discounts (car_id, discount_day, discount_percentage, created_at, updated_at) 
                            VALUES ({$carIds[0]}, 'Monday', 10.00, NOW(), NOW())");
                $db->query("INSERT INTO car_discounts (car_id, discount_day, discount_percentage, created_at, updated_at) 
                            VALUES ({$carIds[0]}, 'Friday', 10.00, NOW(), NOW())");
            }
            
            if (isset($carIds[1])) {
                // Car 2 has discounts on Wednesday and Sunday
                $db->query("INSERT INTO car_discounts (car_id, discount_day, discount_percentage, created_at, updated_at) 
                            VALUES ({$carIds[1]}, 'Wednesday', 10.00, NOW(), NOW())");
                $db->query("INSERT INTO car_discounts (car_id, discount_day, discount_percentage, created_at, updated_at) 
                            VALUES ({$carIds[1]}, 'Sunday', 10.00, NOW(), NOW())");
            }
            
            if (isset($carIds[2])) {
                // Car 3 has discount on Saturday
                $db->query("INSERT INTO car_discounts (car_id, discount_day, discount_percentage, created_at, updated_at) 
                            VALUES ({$carIds[2]}, 'Saturday', 10.00, NOW(), NOW())");
            }
            
            CLI::write('Sample discount data inserted successfully!', 'green');
        } catch (\Exception $e) {
            CLI::error('Error inserting sample data: ' . $e->getMessage());
        }
    }
} 