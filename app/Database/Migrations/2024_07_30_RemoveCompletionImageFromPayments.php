<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveCompletionImageFromPayments extends Migration
{
    public function up()
    {
        // Check if column exists before dropping
        try {
            $this->db->query("SELECT completion_image FROM payments LIMIT 1");
            // If no exception, column exists, so drop it
            $this->db->query("ALTER TABLE payments DROP COLUMN completion_image");
        } catch (\Exception $e) {
            // Column doesn't exist, nothing to do
        }
    }

    public function down()
    {
        // Add the column back if needed
        $this->forge->addColumn('payments', [
            'completion_image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'payment_proof'
            ]
        ]);
    }
} 