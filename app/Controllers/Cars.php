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
        
        // Start building the query with available status
        $carModel->where('status', 'available');
        
        // Apply category filter
        if ($category) {
            $carModel->where('category_id', $category);
        }

        // Get all available cars first
        $cars = $carModel->findAll();
        
        // Then filter by price (24 jam dalam/luar kota) with discount consideration
        if (($minPrice !== '' && $minPrice !== null) || ($maxPrice !== '' && $maxPrice !== null)) {
            $filteredCars = [];
            
            foreach ($cars as $car) {
                // Use daily_rate directly as the "24 jam dalam/luar kota" price
                $basePrice = $car['daily_rate']; // Now daily_rate directly represents 24 jam price
                
                // Apply discount if applicable
                if (is_discount_day($car['id'])) {
                    $percentage = get_discount_percentage($car['id']);
                    $discountedPrice = $basePrice * (1 - ($percentage / 100));
                    
                    // Use discounted price for filtering
                    if (
                        ($minPrice === '' || $minPrice === null || $discountedPrice >= (float)$minPrice) &&
                        ($maxPrice === '' || $maxPrice === null || $discountedPrice <= (float)$maxPrice)
                    ) {
                        $filteredCars[] = $car;
                    }
                } else {
                    // No discount, use regular price
                    if (
                        ($minPrice === '' || $minPrice === null || $basePrice >= (float)$minPrice) &&
                        ($maxPrice === '' || $maxPrice === null || $basePrice <= (float)$maxPrice)
                    ) {
                        $filteredCars[] = $car;
                    }
                }
            }
            
            // Use filtered cars
            $cars = $filteredCars;
        }
        
        $data = [
            'title' => 'Available Cars',
            'cars' => $cars,
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