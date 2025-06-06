<?php

namespace App\Controllers;

use App\Models\CarModel;
use App\Models\CategoryModel;
use App\Models\ReviewModel;

class Home extends BaseController
{
    public function index()
    {
        $carModel = new CarModel();
        $categoryModel = new CategoryModel();
        
        $data = [
            'title' => 'Welcome to CarRent - Your Premium Car Rental Service',
            'cars' => $carModel->where('status', 'available')->findAll(6),
            'categories' => $categoryModel->findAll(),
            'featured_cars' => $carModel->where('status', 'available')->orderBy('RAND()')->findAll(8)
        ];
        
        file_put_contents('log.txt', json_encode($data));
        return view('home', $data);
    }
    
    public function getAbout()
    {
        $data = [
            'title' => 'About Us - CarRent'
        ];
        
        return view('pages/about', $data);
    }
    
    public function getGallery()
    {
        // Redirect to the Gallery controller
        return redirect()->to('gallery');
    }
    
    public function getBlog()
    {
        $data = [
            'title' => 'Blog - CarRent',
            'posts' => [
                [
                    'id' => 1,
                    'title' => 'Tips Memilih Mobil Rental yang Tepat',
                    'date' => '2023-06-15',
                    'excerpt' => 'Memilih mobil rental yang tepat dapat menghemat biaya dan memberikan kenyamanan selama perjalanan Anda...',
                    'image' => 'assets/images/cars/blog-1.png'
                ],
                [
                    'id' => 2,
                    'title' => 'Panduan Lengkap Menyewa Mobil untuk Liburan',
                    'date' => '2023-07-20',
                    'excerpt' => 'Liburan semakin menyenangkan dengan mobil sewaan yang tepat. Simak panduan lengkap dari kami...',
                    'image' => 'assets/images/cars/blog-2.png'
                ],
                [
                    'id' => 3,
                    'title' => '5 Destinasi Road Trip Terbaik di Indonesia',
                    'date' => '2023-08-05',
                    'excerpt' => 'Indonesia memiliki banyak rute perjalanan yang menakjubkan untuk dijelajahi dengan mobil. Berikut 5 rekomendasi terbaik...',
                    'image' => 'assets/images/cars/blog-3.png'
                ],
            ]
        ];
        
        return view('pages/blog', $data);
    }
    
    public function postReviews()
    {
        $reviewModel = new ReviewModel();
        $validation = \Config\Services::validation();
        
        // Set validation rules
        $validation->setRules([
            'car_id' => 'required|integer',
            'rating' => 'required|integer|greater_than[0]|less_than[6]',
            'comment' => 'required|min_length[10]'
        ]);
        
        // Check if validation passes
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Anda harus login untuk memberikan ulasan');
        }
        
        $userId = session()->get('id');
        $carId = $this->request->getPost('car_id');
        
        // Check if user has already reviewed this car
        if ($reviewModel->hasUserReviewed($userId, $carId)) {
            return redirect()->back()->with('error', 'Anda sudah memberikan ulasan untuk mobil ini');
        }
        
        // Save review data
        $data = [
            'user_id' => $userId,
            'car_id' => $carId,
            'rating' => $this->request->getPost('rating'),
            'comment' => $this->request->getPost('comment'),
        ];
        
        $reviewModel->insert($data);
        
        return redirect()->to('/cars/' . $carId)->with('success', 'Terima kasih! Ulasan Anda sedang menunggu persetujuan admin');
    }
}

