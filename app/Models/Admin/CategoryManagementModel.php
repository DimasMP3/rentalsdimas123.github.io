<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class CategoryManagementModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    // Get all categories with car count
    public function getAllCategoriesWithCarCount()
    {
        $db = \Config\Database::connect();
        
        return $db->table('categories')
                  ->select('categories.*, COUNT(cars.id) as car_count')
                  ->join('cars', 'cars.category_id = categories.id', 'left')
                  ->groupBy('categories.id')
                  ->orderBy('categories.name', 'ASC')
                  ->get()
                  ->getResultArray();
    }
    
    // Get category details
    public function getCategoryDetails($id)
    {
        $db = \Config\Database::connect();
        
        // Basic category info
        $category = $db->table('categories')
                       ->where('id', $id)
                       ->get()
                       ->getRowArray();
        
        if (!$category) {
            return null;
        }
        
        // Get cars in this category
        $cars = $db->table('cars')
                   ->where('category_id', $id)
                   ->get()
                   ->getResultArray();
        
        return [
            'category_info' => $category,
            'cars' => $cars,
            'total_cars' => count($cars)
        ];
    }
    
    // Check if category name is unique
    public function isNameUnique($name, $exceptId = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('categories')
                      ->where('name', $name);
        
        if ($exceptId !== null) {
            $builder->where('id !=', $exceptId);
        }
        
        return $builder->countAllResults() === 0;
    }
    
    // Search categories
    public function searchCategories($keyword)
    {
        $db = \Config\Database::connect();
        
        return $db->table('categories')
                  ->select('categories.*, COUNT(cars.id) as car_count')
                  ->join('cars', 'cars.category_id = categories.id', 'left')
                  ->like('categories.name', $keyword)
                  ->orLike('categories.description', $keyword)
                  ->groupBy('categories.id')
                  ->get()
                  ->getResultArray();
    }
} 