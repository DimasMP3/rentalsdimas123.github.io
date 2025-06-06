<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCarDiscountsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'car_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'discount_day' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'comment' => 'Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday',
            ],
            'discount_percentage' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 10.00,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('car_id', 'cars', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('car_discounts');
    }

    public function down()
    {
        $this->forge->dropTable('car_discounts');
    }
} 