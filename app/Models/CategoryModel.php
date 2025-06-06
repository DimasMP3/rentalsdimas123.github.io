<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    // Get category with car count
    public function getCategoryWithCarCount()
    {
        $builder = $this->db->table('categories');
        $builder->select('categories.*, COUNT(cars.id) as car_count');
        $builder->join('cars', 'cars.category_id = categories.id', 'left');
        $builder->groupBy('categories.id');
        
        return $builder->get()->getResultArray();
    }
}

