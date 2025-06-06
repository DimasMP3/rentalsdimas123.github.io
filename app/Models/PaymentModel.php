<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
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
    
    // Get payment with order information
    public function getPaymentWithOrder($paymentId)
    {
        return $this->db->table('payments')
            ->select('payments.*, orders.start_date, orders.end_date, cars.brand, cars.model')
            ->join('orders', 'orders.id = payments.order_id')
            ->join('cars', 'cars.id = orders.car_id')
            ->where('payments.id', $paymentId)
            ->get()
            ->getRowArray();
    }
    
    // Get total revenue
    public function getTotalRevenue()
    {
        $result = $this->where('status', 'completed')
            ->selectSum('amount')
            ->get()
            ->getRowArray();
            
        return $result['amount'] ?? 0;
    }
    
    // Get payments by order
    public function getPaymentsByOrder($orderId)
    {
        return $this->where('order_id', $orderId)
            ->findAll();
    }
}

