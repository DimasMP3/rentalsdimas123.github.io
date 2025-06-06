<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CreateCarDiscountsTable extends BaseCommand
{
    protected $group = 'Database';
    protected $name = 'create:discounts_table';
    protected $description = 'Creates the car_discounts table in the database';

    public function run(array $params)
    {
        // Get the database connection
        $db = \Config\Database::connect();

        $sql = "CREATE TABLE IF NOT EXISTS `car_discounts` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `car_id` INT(11) NOT NULL,
            `discount_day` VARCHAR(10) NOT NULL COMMENT 'Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday',
            `discount_percentage` DECIMAL(5,2) NOT NULL DEFAULT 10.00,
            `created_at` DATETIME NULL,
            `updated_at` DATETIME NULL,
            PRIMARY KEY (`id`),
            CONSTRAINT `fk_car_discounts_car_id` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

        try {
            $db->query($sql);
            CLI::write('Table car_discounts created successfully!', 'green');
        } catch (\Exception $e) {
            CLI::error('Error creating table: ' . $e->getMessage());
        }
    }
} 