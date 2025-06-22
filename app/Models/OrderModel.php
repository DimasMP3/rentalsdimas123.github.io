<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id',
        'car_id',
        'start_date',
        'end_date',
        'total_price',
        'status',
        'payment_status',
        'payment_method',
        'payment_proof',
        'attachment',
        'notes'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    // Get order with related data
    public function getOrderWithDetails($orderId)
    {
        return $this->select('orders.*, orders.attachment, cars.brand, cars.model, 
        cars.image, cars.year, cars.license_plate, cars.daily_rate, cars.description, 
        users.name as user_name, users.email as user_email')
                    ->join('cars', 'cars.id = orders.car_id')
                    ->join('users', 'users.id = orders.user_id')
                    ->where('orders.id', $orderId)
                    ->first();
    }
    
    // Get all orders with related data
    public function getAllOrdersWithDetails()
    {
        return $this->select('orders.*, cars.brand, cars.model, cars.image, cars.license_plate, users.name as user_name, users.email as user_email')
                    ->join('cars', 'cars.id = orders.car_id')
                    ->join('users', 'users.id = orders.user_id')
                    ->findAll();
    }
    
    // Get orders by user
    public function getOrdersByUser($userId)
    {
        return $this->select('orders.*, cars.brand, cars.model, cars.image, cars.year, cars.license_plate, cars.daily_rate')
                    ->join('cars', 'cars.id = orders.car_id')
                    ->where('orders.user_id', $userId)
                    ->findAll();
    }
    
    // Get orders by status
    public function getOrdersByStatus($status)
    {
        return $this->select('orders.*, cars.brand, cars.model, users.name as user_name')
                    ->join('cars', 'cars.id = orders.car_id')
                    ->join('users', 'users.id = orders.user_id')
                    ->where('orders.status', $status)
                    ->findAll();
    }
    
    // Get orders by date range
    public function getOrdersByDateRange($startDate, $endDate)
    {
        return $this->select('orders.*, cars.brand, cars.model, users.name as user_name')
                    ->join('cars', 'cars.id = orders.car_id')
                    ->join('users', 'users.id = orders.user_id')
                    ->where('orders.start_date >=', $startDate)
                    ->where('orders.end_date <=', $endDate)
                    ->findAll();
    }
} 