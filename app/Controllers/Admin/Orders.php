<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;
use App\Models\OrderModel;
use App\Models\CarModel;
use App\Models\UserModel;
use App\Models\PaymentModel;

class Orders extends BaseController
{
    protected $orderModel;
    protected $carModel;
    protected $userModel;
    protected $paymentModel;
    
    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->carModel = new CarModel();
        $this->userModel = new UserModel();
        $this->paymentModel = new PaymentModel();
    }
    
    public function index()
    {
        $db = \Config\Database::connect();
        
        $orders = $this->orderModel->select('orders.*, cars.brand, cars.model, users.name as user_name')
                            ->join('cars', 'cars.id = orders.car_id')
                            ->join('users', 'users.id = orders.user_id')
                            ->findAll();
        
        // Get additional payment details
        foreach ($orders as &$order) {
            // Find payment details when available
            $payment = $this->paymentModel->where('order_id', $order['id'])->first();
            
            // Process payment method for better readability
            if (!empty($order['payment_method'])) {
                switch ($order['payment_method']) {
                    case 'transfer_bank':
                        $order['payment_method_display'] = 'Transfer Bank';
                        // Add bank name if available in payment
                        if ($payment && !empty($payment['bank_name'])) {
                            $order['payment_method_display'] .= ' (' . strtoupper($payment['bank_name']) . ')';
                        }
                        break;
                    case 'credit_card':
                        $order['payment_method_display'] = 'Kartu Kredit';
                        break;
                    case 'e_wallet':
                        $order['payment_method_display'] = 'E-Wallet';
                        // Add provider if available in payment
                        if ($payment && !empty($payment['ewallet_provider'])) {
                            $order['payment_method_display'] .= ' (' . ucfirst($payment['ewallet_provider']) . ')';
                        }
                        break;
                    case 'qris':
                        $order['payment_method_display'] = 'QRIS';
                        break;
                    case 'paylater':
                        $order['payment_method_display'] = 'Paylater';
                        // Add provider if available in payment
                        if ($payment && !empty($payment['paylater_provider'])) {
                            $order['payment_method_display'] .= ' (' . ucfirst($payment['paylater_provider']) . ')';
                        }
                        break;
                    case 'minimarket':
                        $order['payment_method_display'] = 'Minimarket';
                        // Add provider if available in payment
                        if ($payment && !empty($payment['minimarket_provider'])) {
                            $order['payment_method_display'] .= ' (' . ucfirst($payment['minimarket_provider']) . ')';
                        }
                        break;
                    default:
                        $order['payment_method_display'] = ucfirst(str_replace('_', ' ', $order['payment_method']));
                }
            } else {
                $order['payment_method_display'] = '-';
            }
        }
        
        $data = [
            'title' => 'Manage Orders',
            'orders' => $orders
        ];
        
        return view('admin/orders/index', $data);
    }
    
    public function show($id)
    {
        $order = $this->orderModel->select('orders.*, cars.brand, cars.model, cars.image, cars.year, cars.license_plate, cars.daily_rate, cars.description, users.name as user_name, users.email as user_email, users.phone as user_phone')
                          ->join('cars', 'cars.id = orders.car_id')
                          ->join('users', 'users.id = orders.user_id')
                          ->find($id);
        
        if (!$order) {
            return redirect()->to('/admin/orders')->with('error', 'Order not found');
        }
        
        // Get payment information
        $payment = $this->paymentModel->where('order_id', $id)->first();
        
        $data = [
            'title' => 'Order Details',
            'order' => $order,
            'payment' => $payment
        ];
        
        return view('admin/orders/show', $data);
    }
    
    public function updateStatus($id)
    {
        // Use class property instead of recreating model instance
        $order = $this->orderModel->find($id);
        
        if (!$order) {
            return redirect()->to('/admin/orders')->with('error', 'Order not found');
        }
        
        $status = $this->request->getPost('status');
        
        // Handle file upload
        $attachment = null;
        $file = $this->request->getFile('attachment');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Create upload directory if it doesn't exist
            $uploadPath = ROOTPATH . 'public/uploads/attachments';
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            // Generate a new name for the file
            $newName = $file->getRandomName();
            
            // Move the file to the upload folder
            if ($file->move($uploadPath, $newName)) {
                $attachment = $newName;
            }
        }
        
        // Update order status and attachment if available
        $updateData = [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s') // Add updated timestamp to ensure changes are tracked
        ];
        
        if ($attachment) {
            $updateData['attachment'] = $attachment;
        }
        
        $this->orderModel->update($id, $updateData);
        
        // Update car status based on order status
        if ($status === 'approved') {
            $this->carModel->update($order['car_id'], ['status' => 'rented']);
        } elseif ($status === 'completed') {
            $this->carModel->update($order['car_id'], ['status' => 'available']);
        }
        
        // Redirect back to order detail page instead of order list
        return redirect()->to('/admin/orders/' . $id)->with('success', 'Order status updated successfully');
    }
    
    public function approvePayment($id)
    {
        $order = $this->orderModel->find($id);
        
        if (!$order) {
            return redirect()->to('/admin/orders')->with('error', 'Order not found');
        }
        
        // Get payment record
        $payment = $this->paymentModel->where('order_id', $id)->first();
        
        // If payment record exists, update its status
        if ($payment) {
            $this->paymentModel->update($payment['id'], [
                'status' => 'completed',
                'payment_date' => date('Y-m-d H:i:s')
            ]);
        }
        
        // Update order payment status
        $this->orderModel->update($id, [
            'payment_status' => 'paid'
        ]);
        
        // If order is in pending status, also approve it
        if ($order['status'] === 'pending') {
            $this->orderModel->update($id, ['status' => 'approved']);
            
            // Update car status to rented
            $this->carModel->update($order['car_id'], ['status' => 'rented']);
        }
        
        return redirect()->to('/admin/orders')->with('success', 'Payment has been approved and order status updated');
    }
    
    // Add this method - this is a temporary method to add the attachment column
    public function addAttachmentColumn()
    {
        $db = \Config\Database::connect();
        
        try {
            $db->query("ALTER TABLE orders ADD COLUMN attachment VARCHAR(255) NULL AFTER payment_proof");
            return "Column 'attachment' added successfully to orders table!";
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage() . ". The column might already exist.";
        }
    }
    
    public function exportExcel()
    {
        // Get all orders with related info
        $orders = $this->orderModel->select('orders.*, cars.brand, cars.model, users.name as user_name, users.email as user_email, users.phone as user_phone')
                            ->join('cars', 'cars.id = orders.car_id')
                            ->join('users', 'users.id = orders.user_id')
                            ->findAll();
        
        // Set the filename
        $filename = 'rental_orders_' . date('Y-m-d') . '.csv';
        
        // Set headers for CSV download
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        
        // Open the output stream
        $handle = fopen('php://output', 'w');
        
        // Add the CSV header row
        fputcsv($handle, [
            'ID',
            'Customer Name',
            'Email',
            'Phone',
            'Car',
            'License Plate',
            'Start Date',
            'End Date',
            'Duration (Days)',
            'Total Price',
            'Status',
            'Payment Method',
            'Payment Status'
        ]);
        
        // Add data rows
        foreach ($orders as $order) {
            // Calculate rental duration
            $startDate = new \DateTime($order['start_date']);
            $endDate = new \DateTime($order['end_date']);
            $duration = $startDate->diff($endDate)->days + 1;
            
            // Get car details
            $car = $this->carModel->find($order['car_id']);
            
            // Get payment details
            $payment = $this->paymentModel->where('order_id', $order['id'])->first();
            $paymentMethod = !empty($order['payment_method']) ? ucfirst(str_replace('_', ' ', $order['payment_method'])) : '-';
            
            fputcsv($handle, [
                $order['id'],
                $order['user_name'],
                $order['user_email'],
                $order['user_phone'],
                $order['brand'] . ' ' . $order['model'],
                $car ? $car['license_plate'] : '-',
                date('d M Y', strtotime($order['start_date'])),
                date('d M Y', strtotime($order['end_date'])),
                $duration,
                'Rp ' . number_format($order['total_price'], 0, ',', '.'),
                ucfirst($order['status']),
                $paymentMethod,
                ucfirst($order['payment_status'])
            ]);
        }
        
        // Close the file handle
        fclose($handle);
        exit;
    }
} 