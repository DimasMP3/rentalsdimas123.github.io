<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class PaymentManagementModel extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'order_id', 'amount', 'payment_method', 'payment_proof', 'status', 'payment_date',
        'bank_name', 'ewallet_provider', 'paylater_provider', 'minimarket_provider'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    public function getAllPaymentsWithDetails()
    {
        $db = \Config\Database::connect();
        
        return $db->table('payments')
                  ->select('payments.*, orders.start_date, orders.end_date, orders.status as order_status, users.name as user_name, cars.brand, cars.model')
                  ->join('orders', 'orders.id = payments.order_id')
                  ->join('users', 'users.id = orders.user_id')
                  ->join('cars', 'cars.id = orders.car_id')
                  ->orderBy('payments.created_at', 'DESC')
                  ->get()
                  ->getResultArray();
    }
    
    public function getPaymentDetails($paymentId)
    {
        $db = \Config\Database::connect();
        
        return $db->table('payments')
                  ->select('payments.*, orders.start_date, orders.end_date, orders.status as order_status, orders.total_price, orders.car_id, orders.user_id, users.name as user_name, users.email, users.phone, cars.brand, cars.model, cars.year, cars.license_plate')
                  ->join('orders', 'orders.id = payments.order_id')
                  ->join('users', 'users.id = orders.user_id')
                  ->join('cars', 'cars.id = orders.car_id')
                  ->where('payments.id', $paymentId)
                  ->get()
                  ->getRowArray();
    }
    
    public function updatePaymentStatus($paymentId, $status)
    {
        return $this->update($paymentId, ['status' => $status]);
    }
    
    public function getPaymentsByStatus($status)
    {
        $db = \Config\Database::connect();
        
        return $db->table('payments')
                  ->select('payments.*, orders.start_date, orders.end_date, users.name as user_name')
                  ->join('orders', 'orders.id = payments.order_id')
                  ->join('users', 'users.id = orders.user_id')
                  ->where('payments.status', $status)
                  ->orderBy('payments.created_at', 'DESC')
                  ->get()
                  ->getResultArray();
    }
    
    public function getMonthlyRevenueReport($year)
    {
        $db = \Config\Database::connect();
        
        return $db->query("
            SELECT 
                MONTH(payment_date) as month,
                SUM(amount) as total
            FROM 
                payments
            WHERE 
                status = 'completed' AND
                YEAR(payment_date) = ?
            GROUP BY 
                MONTH(payment_date)
            ORDER BY 
                month
        ", [$year])->getResultArray();
    }
} 