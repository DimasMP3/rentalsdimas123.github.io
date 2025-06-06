<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    public function getDashboardStatistics()
    {
        $db = \Config\Database::connect();
        
        // Total Cars
        $totalCars = $db->table('cars')->countAllResults();
        
        // Available Cars
        $availableCars = $db->table('cars')
                            ->where('status', 'available')
                            ->countAllResults();
        
        // Total Orders
        $totalOrders = $db->table('orders')->countAllResults();
        
        // Active Orders
        $activeOrders = $db->table('orders')
                            ->where('status', 'approved')
                            ->countAllResults();
        
        // Total Users (Customers only)
        $totalUsers = $db->table('users')
                         ->where('role', 'user')
                         ->countAllResults();
        
        // Total Revenue (from completed payments)
        $revenueResult = $db->table('payments')
                           ->where('status', 'completed')
                           ->selectSum('amount')
                           ->get()
                           ->getRowArray();
        $totalRevenue = $revenueResult['amount'] ?? 0;
        
        // Recent Orders (last 5)
        $recentOrders = $db->table('orders')
                            ->select('orders.*, users.name as user_name, cars.brand, cars.model, COALESCE(payments.amount, orders.total_price) as amount')
                            ->join('users', 'users.id = orders.user_id')
                            ->join('cars', 'cars.id = orders.car_id')
                            ->join('payments', 'payments.order_id = orders.id', 'left')
                            ->orderBy('orders.created_at', 'DESC')
                            ->limit(5)
                            ->get()
                            ->getResultArray();
                            
        // Pending Orders
        $pendingOrders = $db->table('orders')
                             ->where('status', 'pending')
                             ->countAllResults();
        
        // Completed Orders
        $completedOrders = $db->table('orders')
                               ->where('status', 'completed')
                               ->countAllResults();
                               
        // Monthly Revenue (last 6 months)
        $monthlyRevenue = $db->query('
            SELECT 
                MONTH(created_at) as month, 
                YEAR(created_at) as year,
                SUM(amount) as revenue
            FROM payments
            WHERE 
                status = "completed" AND
                created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
            GROUP BY YEAR(created_at), MONTH(created_at)
            ORDER BY YEAR(created_at), MONTH(created_at)
        ')->getResultArray();
        
        return [
            'total_cars' => $totalCars,
            'available_cars' => $availableCars,
            'total_rentals' => $totalOrders,
            'active_rentals' => $activeOrders,
            'total_users' => $totalUsers,
            'total_revenue' => $totalRevenue,
            'recent_rentals' => $recentOrders,
            'pending_rentals' => $pendingOrders,
            'completed_rentals' => $completedOrders,
            'monthly_revenue' => $monthlyRevenue
        ];
    }
    
    public function getTopRentedCars($limit = 5)
    {
        $db = \Config\Database::connect();
        
        return $db->table('orders')
                  ->select('cars.id, cars.brand, cars.model, COUNT(*) as rental_count')
                  ->join('cars', 'cars.id = orders.car_id')
                  ->groupBy('cars.id, cars.brand, cars.model')
                  ->orderBy('rental_count', 'DESC')
                  ->limit($limit)
                  ->get()
                  ->getResultArray();
    }
    
    public function getRecentPayments($limit = 5)
    {
        $db = \Config\Database::connect();
        
        return $db->table('payments')
                  ->select('payments.*, users.name as user_name, orders.start_date, orders.end_date')
                  ->join('orders', 'orders.id = payments.order_id')
                  ->join('users', 'users.id = orders.user_id')
                  ->orderBy('payments.created_at', 'DESC')
                  ->limit($limit)
                  ->get()
                  ->getResultArray();
    }
} 