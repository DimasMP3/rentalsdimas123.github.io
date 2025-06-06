<?php

namespace App\Controllers;

use App\Models\CarModel;
use App\Models\CategoryModel;
use App\Models\ReviewModel;

class Cars extends BaseController
{
    public function index()
    {
        $carModel = new CarModel();
        $categoryModel = new CategoryModel();
        
        // Get filter parameters
        $category = $this->request->getGet('category');
        $minPrice = $this->request->getGet('min_price');
        $maxPrice = $this->request->getGet('max_price');
        
        // Apply filters
        if ($category) {
            $carModel->where('category_id', $category);
        }
        
        if ($minPrice) {
            $carModel->where('daily_rate >=', $minPrice);
        }
        
        if ($maxPrice) {
            $carModel->where('daily_rate <=', $maxPrice);
        }
        
        $data = [
            'title' => 'Available Cars',
            'cars' => $carModel->where('status', 'available')->findAll(),
            'categories' => $categoryModel->findAll()
        ];
        
        return view('cars/index', $data);
    }
    
    public function show($id)
    {
        $carModel = new \App\Models\CarModel();
        $reviewModel = new \App\Models\ReviewModel();
        
        $car = $carModel->find($id);
        
        if (!$car) {
            return redirect()->to('/cars')->with('error', 'Mobil tidak ditemukan');
        }
        
        // Get approved reviews for this car
        $builder = $reviewModel->builder();
        $builder->select('reviews.*, users.name as username, users.email, orders.id as rental_id, orders.start_date, orders.end_date');
        $builder->join('users', 'users.id = reviews.user_id', 'left');
        $builder->join('orders', 'orders.id = reviews.rental_id', 'left');
        $builder->where('reviews.car_id', $id);
        $builder->where('reviews.is_approved', 1);
        $builder->orderBy('reviews.created_at', 'DESC');
        
        $reviews = $builder->get()->getResultArray();
        
        // Calculate average rating
        $totalRating = 0;
        $reviewCount = count($reviews);
        
        foreach ($reviews as $review) {
            $totalRating += $review['rating'];
        }
        
        $averageRating = $reviewCount > 0 ? round($totalRating / $reviewCount, 1) : 0;
        
        $data = [
            'title' => $car['brand'] . ' ' . $car['model'],
            'car' => $car,
            'reviews' => $reviews,
            'reviewCount' => $reviewCount,
            'averageRating' => $averageRating
        ];
        
        return view('cars/show', $data);
    }
    
    public function byCategory($categoryId)
    {
        $carModel = new CarModel();
        $categoryModel = new CategoryModel();
        
        $category = $categoryModel->find($categoryId);
        
        if (!$category) {
            return redirect()->to('/cars')->with('error', 'Category not found');
        }
        
        $data = [
            'title' => 'Cars in ' . $category['name'] . ' Category',
            'cars' => $carModel->where('category_id', $categoryId)->where('status', 'available')->findAll(),
            'categories' => $categoryModel->findAll(),
            'current_category' => $category
        ];
        
        return view('cars/index', $data);
    }
}