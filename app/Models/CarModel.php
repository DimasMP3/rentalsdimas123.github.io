<?php

namespace App\Models;

use CodeIgniter\Model;

class CarModel extends Model
{
    protected $table = 'cars';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'brand', 'model', 'year', 'license_plate', 'daily_rate',
        'description', 'image', 'status', 'category_id'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    // Get car with category information
    public function getCarWithCategory($carId)
    {
        return $this->db->table('cars')
            ->join('categories', 'categories.id = cars.category_id')
            ->where('cars.id', $carId)
            ->get()
            ->getRowArray();
    }
    
    // Get cars by category
    public function getCarsByCategory($categoryId)
    {
        return $this->where('category_id', $categoryId)
            ->where('status', 'available')
            ->findAll();
    }
    
    // Get available cars
    public function getAvailableCars()
    {
        return $this->where('status', 'available')
            ->findAll();
    }
}

