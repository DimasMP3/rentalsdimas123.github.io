<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model
{
    protected $table            = 'reviews';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['user_id', 'car_id', 'rental_id', 'rating', 'comment', 'is_approved'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    
    /**
     * Check if user has already reviewed this car
     *
     * @param int $userId
     * @param int $carId
     * @return bool
     */
    public function hasUserReviewed($userId, $carId)
    {
        $count = $this->where('user_id', $userId)
                      ->where('car_id', $carId)
                      ->countAllResults();
                      
        return ($count > 0);
    }
    
    /**
     * Check if user has already reviewed this rental
     *
     * @param int $userId
     * @param int $rentalId
     * @return bool
     */
    public function hasUserReviewedRental($userId, $rentalId)
    {
        $count = $this->where('user_id', $userId)
                      ->where('rental_id', $rentalId)
                      ->countAllResults();
                      
        return ($count > 0);
    }
} 