<?php

namespace App\Models;

use CodeIgniter\Model;

class CarDiscountModel extends Model
{
    protected $table = 'car_discounts';
    protected $primaryKey = 'id';
    
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    
    protected $useSoftDeletes = false;
    
    protected $allowedFields = [
        'car_id', 
        'discount_day', 
        'discount_percentage',
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    // Get all discount days for a specific car
    public function getCarDiscountDays($carId)
    {
        return $this->where('car_id', $carId)->findAll();
    }
    
    // Check if a car has discount on a specific day
    public function hasDiscountOnDay($carId, $day)
    {
        return $this->where('car_id', $carId)
                    ->where('discount_day', $day)
                    ->countAllResults() > 0;
    }
    
    // Get discount percentage for a car on a specific day
    public function getDiscountPercentage($carId, $day)
    {
        $discount = $this->where('car_id', $carId)
                         ->where('discount_day', $day)
                         ->first();
        
        return $discount ? $discount['discount_percentage'] : 0;
    }
    
    // Delete all discount days for a car (used before updating with new values)
    public function deleteCarDiscounts($carId)
    {
        return $this->where('car_id', $carId)->delete();
    }
} 