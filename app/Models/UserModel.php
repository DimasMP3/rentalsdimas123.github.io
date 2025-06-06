<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [
        'name', 'email', 'password', 'phone', 'address', 
        'license_number', 'role', 'status', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'name' => 'required|min_length[3]',
        'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
        'password' => 'required|min_length[6]'
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    
    // Join with rentals to get user's rental history
    public function getRentalHistory($userId)
    {
        return $this->db->table('rentals')
            ->join('cars', 'cars.id = rentals.car_id')
            ->where('rentals.user_id', $userId)
            ->get()
            ->getResultArray();
    }
    
    // Verify if a user exists with the given ID
    public function verifyUserExists($userId)
    {
        return $this->where('id', $userId)->countAllResults() > 0;
    }
    
    // Get user by email
    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }
}

