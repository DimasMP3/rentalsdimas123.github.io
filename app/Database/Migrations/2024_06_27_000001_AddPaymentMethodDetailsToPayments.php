<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPaymentMethodDetailsToPayments extends Migration
{
    public function up()
    {
        $this->forge->addColumn('payments', [
            'bank_name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'payment_method'
            ],
            'ewallet_provider' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'bank_name'
            ],
            'paylater_provider' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'ewallet_provider'
            ],
            'minimarket_provider' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'paylater_provider'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('payments', ['bank_name', 'ewallet_provider', 'paylater_provider', 'minimarket_provider']);
    }
} 