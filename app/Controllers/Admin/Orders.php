<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;
use App\Models\OrderModel;
use App\Models\CarModel;
use App\Models\UserModel;
use App\Models\PaymentModel;
use App\Models\Admin\PaymentManagementModel;

class Orders extends BaseController
{
    protected $orderModel;
    protected $carModel;
    protected $userModel;
    protected $paymentModel;
    protected $paymentManagementModel;
    
    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->carModel = new CarModel();
        $this->userModel = new UserModel();
        $this->paymentModel = new PaymentModel();
        $this->paymentManagementModel = new PaymentManagementModel();
    }
    
    public function index()
    {
        $db = \Config\Database::connect();
        
        // Load payment helper
        helper('payment');
        
        $orders = $this->orderModel->select('orders.*, cars.brand, cars.model, users.name as user_name')
                            ->join('cars', 'cars.id = orders.car_id')
                            ->join('users', 'users.id = orders.user_id')
                            ->findAll();
        
        // Get additional payment details but we don't need to pre-format them
        // since we'll use the payment helper directly in the view
        foreach ($orders as &$order) {
            // Find payment details when available
            $payment = $this->paymentModel->where('order_id', $order['id'])->first();
            
            // Fix payment method if needed
            if ($payment && empty($payment['payment_method']) && 
                (!empty($payment['bank_name']) || 
                !empty($payment['ewallet_provider']) || 
                !empty($payment['paylater_provider']) || 
                !empty($payment['minimarket_provider']))) {
                
                // Use the helper function
                fix_payment_method($payment['id']);
                
                // Reload payment after fixing
                $payment = $this->paymentModel->find($payment['id']);
            }
            
            // Store payment in order for view access
            $order['payment'] = $payment;
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
        
        // Get payment information directly
        $payment = $this->paymentModel->where('order_id', $id)->first();
        
        // If payment exists but payment_method is empty, auto-fix based on provider fields
        if ($payment) {
            $db = \Config\Database::connect();
            
            // Direct SQL fix for this specific payment
            if (empty($payment['payment_method'])) {
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
            
            // Ensure we have payment method info for the view
            if (empty($payment['payment_method']) && !empty($payment['bank_name'])) {
                $payment['payment_method'] = 'bank_transfer';
            } elseif (empty($payment['payment_method']) && !empty($payment['ewallet_provider'])) {
                $payment['payment_method'] = 'e_wallet';
            } elseif (empty($payment['payment_method']) && !empty($payment['paylater_provider'])) {
                $payment['payment_method'] = 'paylater';
            } elseif (empty($payment['payment_method']) && !empty($payment['minimarket_provider'])) {
                $payment['payment_method'] = 'minimarket';
            }
            
            log_message('info', 'Payment found for order ' . $id . ': ' . json_encode($payment));
        } else {
            log_message('info', 'No payment found for order ' . $id);
        }
        
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
        // Load payment helper
        helper('payment');
        
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
            
            // Get payment details using helper
            $payment = $this->paymentModel->where('order_id', $order['id'])->first();
            
            // Fix payment method if needed
            if ($payment && empty($payment['payment_method']) && 
                (!empty($payment['bank_name']) || 
                !empty($payment['ewallet_provider']) || 
                !empty($payment['paylater_provider']) || 
                !empty($payment['minimarket_provider']))) {
                
                fix_payment_method($payment['id']);
                $payment = $this->paymentModel->find($payment['id']);
            }
            
            // Detect and format payment method
            $paymentMethodText = '-';
            if ($payment) {
                $paymentMethodData = detect_payment_method($payment);
                if (!empty($paymentMethodData['method'])) {
                    $paymentMethodText = format_payment_method($paymentMethodData);
                }
            } elseif (!empty($order['payment_method'])) {
                $paymentMethodText = format_payment_method($order['payment_method']);
            }
            
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
                $paymentMethodText,
                ucfirst($order['payment_status'])
            ]);
        }
        
        // Close the file handle
        fclose($handle);
        exit;
    }
    
    // Function to fix all payment methods in the database
    public function fixAllPaymentMethods()
    {
        $db = \Config\Database::connect();
        
        // Direct SQL fix for all payments
        $sql = "UPDATE payments SET payment_method = CASE 
                    WHEN bank_name != '' THEN 'bank_transfer' 
                    WHEN ewallet_provider != '' THEN 'e_wallet' 
                    WHEN paylater_provider != '' THEN 'paylater' 
                    WHEN minimarket_provider != '' THEN 'minimarket' 
                    ELSE payment_method 
                END 
                WHERE payment_method = '' OR payment_method IS NULL";
        
        $db->query($sql);
        $affectedRows = $db->affectedRows();
        
        return 'Fixed ' . $affectedRows . ' payment records.';
    }
    
    // Diagnostic function to check payment method detection
    public function checkPaymentMethod($id)
    {
        // Get payment information
        $payment = $this->paymentModel->where('order_id', $id)->first();
        
        if (!$payment) {
            return 'No payment found for order ID: ' . $id;
        }
        
        $output = '<h3>Payment Method Diagnostic</h3>';
        $output .= '<p>Payment ID: ' . $payment['id'] . '</p>';
        $output .= '<p>Order ID: ' . $payment['order_id'] . '</p>';
        $output .= '<p>Payment Method: ' . ($payment['payment_method'] ?: 'Not set') . '</p>';
        $output .= '<p>Bank Name: ' . ($payment['bank_name'] ?: 'Not set') . '</p>';
        $output .= '<p>E-Wallet Provider: ' . ($payment['ewallet_provider'] ?: 'Not set') . '</p>';
        $output .= '<p>Paylater Provider: ' . ($payment['paylater_provider'] ?: 'Not set') . '</p>';
        $output .= '<p>Minimarket Provider: ' . ($payment['minimarket_provider'] ?: 'Not set') . '</p>';
        
        // Detected payment method
        $detectedMethod = '';
        if (!empty($payment['bank_name'])) {
            $detectedMethod = 'bank_transfer (' . $payment['bank_name'] . ')';
        } elseif (!empty($payment['ewallet_provider'])) {
            $detectedMethod = 'e_wallet (' . $payment['ewallet_provider'] . ')';
        } elseif (!empty($payment['paylater_provider'])) {
            $detectedMethod = 'paylater (' . $payment['paylater_provider'] . ')';
        } elseif (!empty($payment['minimarket_provider'])) {
            $detectedMethod = 'minimarket (' . $payment['minimarket_provider'] . ')';
        }
        
        $output .= '<p>Detected Method: ' . ($detectedMethod ?: 'Could not detect') . '</p>';
        
        // Order payment method
        $order = $this->orderModel->find($payment['order_id']);
        if ($order) {
            $output .= '<p>Order Payment Method: ' . ($order['payment_method'] ?: 'Not set') . '</p>';
        }
        
        $output .= '<hr>';
        $output .= '<a href="' . site_url('admin/orders/' . $id) . '" class="btn btn-primary">Return to Order</a> ';
        $output .= '<a href="' . site_url('admin/orders/fix-payment-methods') . '" class="btn btn-warning">Fix All Payment Methods</a>';
        
        return $output;
    }
} 