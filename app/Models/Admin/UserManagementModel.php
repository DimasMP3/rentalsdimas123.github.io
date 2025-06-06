<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class UserManagementModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'email', 'phone', 'address', 'license_number', 'role', 'status'
    ];
    protected $useTimestamps = true;
    
    public function getUsersWithRentalCount()
    {
        $db = \Config\Database::connect();
        
        return $db->table('users')
                  ->select('users.*, COUNT(rentals.id) as rental_count')
                  ->join('rentals', 'rentals.user_id = users.id', 'left')
                  ->groupBy('users.id')
                  ->get()
                  ->getResultArray();
    }
    
    public function getUserDetails($userId)
    {
        $db = \Config\Database::connect();
        
        // Get basic user info
        $user = $db->table('users')
                   ->where('id', $userId)
                   ->get()
                   ->getRowArray();
        
        if (!$user) {
            return null;
        }
        
        // Get user's rental history
        $rentalHistory = $db->table('rentals')
                            ->select('rentals.*, cars.brand, cars.model, cars.year, payments.amount as payment_amount, payments.status as payment_status')
                            ->join('cars', 'cars.id = rentals.car_id')
                            ->join('payments', 'payments.rental_id = rentals.id', 'left')
                            ->where('rentals.user_id', $userId)
                            ->orderBy('rentals.created_at', 'DESC')
                            ->get()
                            ->getResultArray();
        
        // Get user's payment history
        $paymentHistory = $db->table('payments')
                            ->select('payments.*, rentals.pickup_date, rentals.return_date, cars.brand, cars.model')
                            ->join('rentals', 'rentals.id = payments.rental_id')
                            ->join('cars', 'cars.id = rentals.car_id')
                            ->where('rentals.user_id', $userId)
                            ->orderBy('payments.created_at', 'DESC')
                            ->get()
                            ->getResultArray();
                            
        // Combine all information
        return [
            'user_info' => $user,
            'rental_history' => $rentalHistory,
            'payment_history' => $paymentHistory,
            'total_rentals' => count($rentalHistory),
            'total_spent' => array_sum(array_column($paymentHistory, 'amount'))
        ];
    }
    
    public function updateUserStatus($userId, $status)
    {
        return $this->update($userId, ['status' => $status]);
    }
    
    public function searchUsers($keyword)
    {
        return $this->like('name', $keyword)
                    ->orLike('email', $keyword)
                    ->orLike('phone', $keyword)
                    ->findAll();
    }
} 