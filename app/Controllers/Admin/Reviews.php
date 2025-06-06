<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ReviewModel;
use App\Models\OrderModel;
use App\Models\UserModel;
use App\Models\CarModel;

class Reviews extends BaseController
{
    protected $reviewModel;
    protected $orderModel;
    protected $userModel;
    protected $carModel;
    
    public function __construct()
    {
        $this->reviewModel = new ReviewModel();
        $this->orderModel = new OrderModel();
        $this->userModel = new UserModel();
        $this->carModel = new CarModel();
    }
    
    public function index()
    {
        // Get all reviews with user and car details
        $builder = $this->reviewModel->builder();
        $builder->select('reviews.*, users.name as username, cars.brand, cars.model, orders.id as rental_id');
        $builder->join('users', 'users.id = reviews.user_id', 'left');
        $builder->join('cars', 'cars.id = reviews.car_id', 'left');
        $builder->join('orders', 'orders.id = reviews.rental_id', 'left');
        $builder->orderBy('reviews.created_at', 'DESC');
        
        $reviews = $builder->get()->getResultArray();
        
        $data = [
            'title' => 'Kelola Ulasan',
            'reviews' => $reviews
        ];
        
        return view('admin/reviews/index', $data);
    }
    
    public function approve($id)
    {
        $review = $this->reviewModel->find($id);
        
        if (!$review) {
            return redirect()->to('/admin/reviews')->with('error', 'Ulasan tidak ditemukan');
        }
        
        $this->reviewModel->update($id, ['is_approved' => 1]);
        
        return redirect()->to('/admin/reviews')->with('success', 'Ulasan berhasil disetujui');
    }
    
    public function reject($id)
    {
        $review = $this->reviewModel->find($id);
        
        if (!$review) {
            return redirect()->to('/admin/reviews')->with('error', 'Ulasan tidak ditemukan');
        }
        
        $this->reviewModel->update($id, ['is_approved' => 0]);
        
        return redirect()->to('/admin/reviews')->with('success', 'Ulasan berhasil ditolak');
    }
    
    public function delete($id)
    {
        $review = $this->reviewModel->find($id);
        
        if (!$review) {
            return redirect()->to('/admin/reviews')->with('error', 'Ulasan tidak ditemukan');
        }
        
        $this->reviewModel->delete($id);
        
        return redirect()->to('/admin/reviews')->with('success', 'Ulasan berhasil dihapus');
    }
    
    public function details($id)
    {
        $builder = $this->reviewModel->builder();
        $builder->select('reviews.*, users.name as username, users.email, cars.brand, cars.model, cars.image, orders.id as rental_id, orders.start_date, orders.end_date');
        $builder->join('users', 'users.id = reviews.user_id', 'left');
        $builder->join('cars', 'cars.id = reviews.car_id', 'left');
        $builder->join('orders', 'orders.id = reviews.rental_id', 'left');
        $builder->where('reviews.id', $id);
        
        $review = $builder->get()->getRowArray();
        
        if (!$review) {
            return redirect()->to('/admin/reviews')->with('error', 'Ulasan tidak ditemukan');
        }
        
        $data = [
            'title' => 'Detail Ulasan',
            'review' => $review
        ];
        
        return view('admin/reviews/details', $data);
    }
} 