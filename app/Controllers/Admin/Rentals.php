<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;
use App\Models\RentalModel;
use App\Models\CarModel;
use App\Models\UserModel;
use App\Models\PaymentModel;

class Rentals extends BaseController
{
    protected $rentalModel;
    protected $carModel;
    protected $userModel;
    protected $paymentModel;
    
    public function __construct()
    {
        $this->rentalModel = new RentalModel();
        $this->carModel = new CarModel();
        $this->userModel = new UserModel();
        $this->paymentModel = new PaymentModel();
    }
    
    public function index()
    {
        $db = \Config\Database::connect();
        
        $rentals = $db->table('rentals')
                      ->select('rentals.*, users.name as user_name, cars.brand, cars.model')
                      ->join('users', 'users.id = rentals.user_id')
                      ->join('cars', 'cars.id = rentals.car_id')
                      ->orderBy('rentals.created_at', 'DESC')
                      ->get()
                      ->getResultArray();
        
        $data = [
            'title' => 'Pengelolaan Penyewaan',
            'rentals' => $rentals
        ];
        
        return view('admin/rentals/index', $data);
    }
    
    public function show($id)
    {
        $db = \Config\Database::connect();
        
        $rental = $db->table('rentals')
                     ->select('rentals.*, users.name as user_name, users.email, users.phone, users.address, users.license_number, cars.brand, cars.model, cars.year, cars.license_plate, cars.price_per_day')
                     ->join('users', 'users.id = rentals.user_id')
                     ->join('cars', 'cars.id = rentals.car_id')
                     ->where('rentals.id', $id)
                     ->get()
                     ->getRowArray();
        
        if (!$rental) {
            return redirect()->to('/admin/rentals')->with('error', 'Data penyewaan tidak ditemukan');
        }
        
        // Get payment information if exists
        $payment = $this->paymentModel->where('rental_id', $id)->first();
        
        $data = [
            'title' => 'Detail Penyewaan',
            'rental' => $rental,
            'payment' => $payment
        ];
        
        return view('admin/rentals/show', $data);
    }
    
    public function updateStatus($id)
    {
        $status = $this->request->getPost('status');
        
        if (!in_array($status, ['pending', 'active', 'completed', 'cancelled'])) {
            return redirect()->back()->with('error', 'Status penyewaan tidak valid');
        }
        
        if ($this->rentalModel->update($id, ['status' => $status])) {
            // Jika status diubah menjadi completed, cek dan update status mobil
            if ($status == 'completed') {
                $rental = $this->rentalModel->find($id);
                if ($rental) {
                    $this->carModel->update($rental['car_id'], ['status' => 'available']);
                }
            } 
            // Jika status diubah menjadi active, update status mobil menjadi rented
            else if ($status == 'active') {
                $rental = $this->rentalModel->find($id);
                if ($rental) {
                    $this->carModel->update($rental['car_id'], ['status' => 'rented']);
                }
            }
            
            return redirect()->to('/admin/rentals')->with('success', 'Status penyewaan berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui status penyewaan');
        }
    }
    
    public function filter()
    {
        $status = $this->request->getGet('status');
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');
        
        $db = \Config\Database::connect();
        $builder = $db->table('rentals')
                      ->select('rentals.*, users.name as user_name, cars.brand, cars.model')
                      ->join('users', 'users.id = rentals.user_id')
                      ->join('cars', 'cars.id = rentals.car_id');
        
        if ($status && $status != 'all') {
            $builder->where('rentals.status', $status);
        }
        
        if ($startDate) {
            $builder->where('rentals.pickup_date >=', $startDate);
        }
        
        if ($endDate) {
            $builder->where('rentals.return_date <=', $endDate);
        }
        
        $rentals = $builder->orderBy('rentals.created_at', 'DESC')
                           ->get()
                           ->getResultArray();
        
        $data = [
            'title' => 'Filter Penyewaan',
            'rentals' => $rentals,
            'status' => $status,
            'start_date' => $startDate,
            'end_date' => $endDate
        ];
        
        return view('admin/rentals/filter', $data);
    }
    
    public function report()
    {
        $month = $this->request->getGet('month') ?? date('m');
        $year = $this->request->getGet('year') ?? date('Y');
        
        $db = \Config\Database::connect();
        
        $rentals = $db->table('rentals')
                      ->select('rentals.*, users.name as user_name, cars.brand, cars.model')
                      ->join('users', 'users.id = rentals.user_id')
                      ->join('cars', 'cars.id = rentals.car_id')
                      ->where('MONTH(rentals.created_at)', $month)
                      ->where('YEAR(rentals.created_at)', $year)
                      ->orderBy('rentals.created_at', 'DESC')
                      ->get()
                      ->getResultArray();
        
        $data = [
            'title' => 'Laporan Penyewaan',
            'rentals' => $rentals,
            'month' => $month,
            'year' => $year
        ];
        
        return view('admin/rentals/report', $data);
    }
} 