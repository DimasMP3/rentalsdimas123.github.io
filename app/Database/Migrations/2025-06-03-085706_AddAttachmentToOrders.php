<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAttachmentToOrders extends Migration
{
    public function up()
    {
        $this->forge->addColumn('orders', [
            'attachment' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'payment_proof'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('orders', 'attachment');
    }
}
