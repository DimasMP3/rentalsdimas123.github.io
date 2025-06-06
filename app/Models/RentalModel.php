<?php

namespace App\Models;

use CodeIgniter\Model;

class RentalModel extends Model
{
    protected $table = 'rentals';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id', 'car_id', 'pickup_date', 'return_date',
        'total_amount', 'status'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    // Get rental with car and user information
    public function getRentalDetails($rentalId)
    {
        return $this->db->table('rentals')
            ->select('rentals.*, cars.brand, cars.model, cars.image, users.name as user_name, users.email as user_email')
            ->join('cars', 'cars.id = rentals.car_id')
            ->join('users', 'users.id = rentals.user_id')
            ->where('rentals.id', $rentalId)
            ->get()
            ->getRowArray();
    }
    
    // Get user's rentals with car information
    public function getUserRentals($userId)
    {
        return $this->db->table('rentals')
            ->select('rentals.*, cars.brand, cars.model, cars.image')
            ->join('cars', 'cars.id = rentals.car_id')
            ->where('rentals.user_id', $userId)
            ->orderBy('rentals.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }
    
    // Get active rentals
    public function getActiveRentals()
    {
        return $this->where('status', 'active')
            ->findAll();
    }
}

