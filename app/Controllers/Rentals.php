<?php

namespace App\Controllers;

use App\Models\CarModel;
use App\Models\OrderModel;
use App\Models\PaymentModel;
use App\Models\ReviewModel;

class Rentals extends BaseController
{
    protected $carModel;
    protected $orderModel;
    protected $paymentModel;
    protected $reviewModel;
    
    public function __construct()
    {
        $this->carModel = new CarModel();
        $this->orderModel = new OrderModel();
        $this->paymentModel = new PaymentModel();
        $this->reviewModel = new ReviewModel();
    }
    
    public function index()
    {
        $data = [
            'title' => 'My Rentals',
            'orders' => $this->orderModel->getOrdersByUser(session()->get('user_id'))
        ];
        
        return view('rentals/index', $data);
    }
    
    public function create($carId)
    {
        $car = $this->carModel->find($carId);
        
        if (!$car || $car['status'] != 'available') {
            return redirect()->to('/cars')->with('error', 'Mobil tidak tersedia untuk disewa');
        }
        
        $data = [
            'title' => 'Rent a Car',
            'car' => $car
        ];
        
        return view('rentals/create', $data);
    }
    
    public function store()
    {
        $rules = [
            'car_id' => 'required|numeric',
            'start_date' => 'required|valid_date',
            'end_date' => 'required|valid_date',
            'payment_method' => 'required'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $carId = $this->request->getPost('car_id');
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');
        $paymentMethod = $this->request->getPost('payment_method');
        
        // Get the total price from the form (including any discounts)
        $totalPrice = $this->request->getPost('total_price');
        
        // If total_price is not provided or invalid, calculate it the old way
        if (!$totalPrice || !is_numeric($totalPrice)) {
            // Calculate total days and price
            $start = new \DateTime($startDate);
            $end = new \DateTime($endDate);
            $days = $end->diff($start)->days + 1;
            
            $car = $this->carModel->find($carId);
            $totalPrice = $car['daily_rate'] * $days;
        }
        
        // Create order
        $orderData = [
            'user_id' => session()->get('user_id'),
            'car_id' => $carId,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => $paymentMethod
        ];
        
        $orderId = $this->orderModel->insert($orderData);
        
        if ($orderId) {
            // Update car status
            $this->carModel->update($carId, ['status' => 'pending']);
            
            // Collect additional payment details based on payment method
            $paymentData = [
                'order_id' => $orderId,
                'amount' => $totalPrice,
                'payment_method' => $paymentMethod,
                'status' => 'pending'
            ];
            
            // Log payment method details for debugging
            log_message('info', 'Payment Method: ' . $paymentMethod);
            
            // Collect specific payment method details
            switch ($paymentMethod) {
                case 'bank_transfer':
                    $bankName = $this->request->getPost('bank_name');
                    $paymentData['bank_name'] = $bankName;
                    log_message('info', 'Bank Name: ' . $bankName);
                    break;
                    
                case 'e_wallet':
                    $ewalletProvider = $this->request->getPost('ewallet_provider');
                    $paymentData['ewallet_provider'] = $ewalletProvider;
                    log_message('info', 'E-Wallet Provider: ' . $ewalletProvider);
                    break;
                    
                case 'paylater':
                    $paylaterProvider = $this->request->getPost('paylater_provider');
                    $paymentData['paylater_provider'] = $paylaterProvider;
                    log_message('info', 'Paylater Provider: ' . $paylaterProvider);
                    break;
                    
                case 'minimarket':
                    $minimarketProvider = $this->request->getPost('minimarket_provider');
                    $paymentData['minimarket_provider'] = $minimarketProvider;
                    log_message('info', 'Minimarket Provider: ' . $minimarketProvider);
                    break;
            }
            
            // Handle payment proof upload if provided
            $paymentProof = $this->request->getFile('payment_proof');
            if ($paymentProof && $paymentProof->isValid() && !$paymentProof->hasMoved()) {
                $proofName = $paymentProof->getRandomName();
                $paymentProof->move(ROOTPATH . 'public/uploads/payments', $proofName);
                $paymentData['payment_proof'] = $proofName;
            }
            
            // Create payment record
            $this->paymentModel->insert($paymentData);
            
            return redirect()->to('/rentals')->with('success', 'Pesanan berhasil dibuat. Silakan lakukan pembayaran.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal membuat pesanan');
        }
    }
    
    public function show($id)
    {
        $order = $this->orderModel->getOrderWithDetails($id);
        
        if (!$order || $order['user_id'] != session()->get('user_id')) {
            return redirect()->to('/rentals')->with('error', 'Pesanan tidak ditemukan');
        }
        
        // Get payment record
        $payment = $this->paymentModel->where('order_id', $id)->first();
        
        // Auto-fix payment method if needed
        if ($payment && empty($payment['payment_method'])) {
            $db = \Config\Database::connect();
            
            // Direct SQL fix for this specific payment
            $sql = "UPDATE payments SET payment_method = CASE 
                        WHEN bank_name != '' THEN 'bank_transfer' 
                        WHEN ewallet_provider != '' THEN 'e_wallet' 
                        WHEN paylater_provider != '' THEN 'paylater' 
                        WHEN minimarket_provider != '' THEN 'minimarket' 
                        ELSE payment_method 
                    END 
                    WHERE id = ?";
            $db->query($sql, [$payment['id']]);
            
            // Reload the payment record
            $payment = $this->paymentModel->find($payment['id']);
        }
        
        // Check if user has already reviewed this rental
        $hasReviewed = false;
        if ($order['status'] == 'completed') {
            $hasReviewed = $this->reviewModel->hasUserReviewedRental(session()->get('user_id'), $id);
        }
        
        $data = [
            'title' => 'Order Details',
            'order' => $order,
            'payment' => $payment,
            'hasReviewed' => $hasReviewed
        ];
        
        return view('rentals/show', $data);
    }
    
    public function uploadPayment($id)
    {
        $order = $this->orderModel->find($id);
        
        if (!$order || $order['user_id'] != session()->get('user_id')) {
            return redirect()->to('/rentals')->with('error', 'Pesanan tidak ditemukan');
        }
        
        $paymentProof = $this->request->getFile('payment_proof');
        
        if ($paymentProof->isValid() && !$paymentProof->hasMoved()) {
            $proofName = $paymentProof->getRandomName();
            $paymentProof->move(ROOTPATH . 'public/uploads/payments', $proofName);
            
            // Update payment record
            $payment = $this->paymentModel->where('order_id', $id)->first();
            
            if ($payment) {
                $this->paymentModel->update($payment['id'], [
                    'payment_proof' => $proofName,
                    'status' => 'pending'
                ]);
            } else {
                $this->paymentModel->insert([
                    'order_id' => $id,
                    'amount' => $order['total_price'],
                    'payment_method' => $order['payment_method'],
                    'payment_proof' => $proofName,
                    'status' => 'pending'
                ]);
            }
            
            return redirect()->to('/rentals/' . $id)->with('success', 'Bukti pembayaran berhasil diunggah');
        } else {
            return redirect()->back()->with('error', 'Gagal mengunggah bukti pembayaran');
        }
    }
    
    public function submit_review($id)
    {
        $order = $this->orderModel->find($id);
        
        if (!$order || $order['user_id'] != session()->get('user_id')) {
            return redirect()->to('/rentals')->with('error', 'Pesanan tidak ditemukan');
        }
        
        // Validate that order is completed
        if ($order['status'] != 'completed') {
            return redirect()->to('/rentals/' . $id)->with('error', 'Ulasan hanya dapat diberikan untuk pesanan yang telah selesai');
        }
        
        // Validate that user hasn't already reviewed this rental
        if ($this->reviewModel->hasUserReviewedRental(session()->get('user_id'), $id)) {
            return redirect()->to('/rentals/' . $id)->with('error', 'Anda sudah memberikan ulasan untuk pesanan ini');
        }
        
        $rules = [
            'rating' => 'required|numeric|greater_than[0]|less_than[6]',
            'comment' => 'required|min_length[10]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'user_id' => session()->get('user_id'),
            'car_id' => $order['car_id'],
            'rental_id' => $id,
            'rating' => $this->request->getPost('rating'),
            'comment' => $this->request->getPost('comment'),
            'is_approved' => 0
        ];
        
        if ($this->reviewModel->insert($data)) {
            return redirect()->to('/rentals/' . $id)->with('success', 'Terima kasih! Ulasan Anda telah dikirim dan sedang menunggu persetujuan admin');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengirim ulasan');
        }
    }
}

