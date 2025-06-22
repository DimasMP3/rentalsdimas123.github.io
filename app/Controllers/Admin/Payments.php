<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;
use App\Models\PaymentModel;
use App\Models\OrderModel;
use App\Models\UserModel;

class Payments extends BaseController
{
    protected $paymentModel;
    protected $orderModel;
    protected $userModel;
    
    public function __construct()
    {
        $this->paymentModel = new PaymentModel();
        $this->orderModel = new OrderModel();
        $this->userModel = new UserModel();
    }
    
    public function index()
    {
        $payments = $this->paymentModel->select('payments.*, orders.start_date, orders.end_date, orders.status as order_status, users.name as user_name, cars.brand, cars.model')
                         ->join('orders', 'orders.id = payments.order_id')
                         ->join('users', 'users.id = orders.user_id')
                         ->join('cars', 'cars.id = orders.car_id')
                         ->findAll();
                         
        $data = [
            'title' => 'Payment Management',
            'payments' => $payments
        ];
        
        return view('admin/payments/index', $data);
    }
    
    public function show($id)
    {
        $payment = $this->paymentModel->select('payments.*, orders.start_date, orders.end_date, orders.status as order_status, orders.total_price, orders.car_id, orders.user_id, users.name as user_name, users.email, users.phone, cars.brand, cars.model, cars.year, cars.license_plate')
                         ->join('orders', 'orders.id = payments.order_id')
                         ->join('users', 'users.id = orders.user_id')
                         ->join('cars', 'cars.id = orders.car_id')
                         ->where('payments.id', $id)
                         ->first();
                         
        if (!$payment) {
            return redirect()->to('/admin/payments')->with('error', 'Payment not found');
        }
        
        $data = [
            'title' => 'Payment Details',
            'payment' => $payment
        ];
        
        return view('admin/payments/show', $data);
    }
    
    public function updateStatus($id)
    {
        $status = $this->request->getPost('status');
        
        $this->paymentModel->update($id, [
            'status' => $status,
            'payment_date' => ($status == 'completed') ? date('Y-m-d H:i:s') : null
        ]);
        
        // If payment is completed, update order payment status as well
        if ($status == 'completed') {
            $payment = $this->paymentModel->find($id);
            if ($payment) {
                $this->orderModel->update($payment['order_id'], [
                    'payment_status' => 'paid'
                ]);
            }
        }
        
        return redirect()->to('/admin/payments')->with('success', 'Payment status updated successfully');
    }
    
    public function fixPaymentMethods()
    {
        // Get all payments with empty payment_method but has bank_name
        $payments = $this->paymentModel->where('payment_method', '')
                         ->whereNotIn('bank_name', [''])
                         ->findAll();
        
        $count = 0;
        foreach ($payments as $payment) {
            // Set payment_method to bank_transfer if bank_name exists
            if (!empty($payment['bank_name'])) {
                $this->paymentModel->update($payment['id'], [
                    'payment_method' => 'bank_transfer'
                ]);
                $count++;
            }
        }
        
        // Get all payments with empty payment_method but has ewallet_provider
        $payments = $this->paymentModel->where('payment_method', '')
                         ->whereNotIn('ewallet_provider', [''])
                         ->findAll();
        
        foreach ($payments as $payment) {
            // Set payment_method to e_wallet if ewallet_provider exists
            if (!empty($payment['ewallet_provider'])) {
                $this->paymentModel->update($payment['id'], [
                    'payment_method' => 'e_wallet'
                ]);
                $count++;
            }
        }
        
        // Return results
        return $count . ' payment records have been fixed.';
    }
    
    public function exportCsv()
    {
        // Load payment helper
        helper('payment');
        
        // Get all payments with related order and user data
        $payments = $this->paymentModel->select('payments.*, orders.start_date, orders.end_date, orders.total_price, users.name as user_name')
                               ->join('orders', 'orders.id = payments.order_id')
                               ->join('users', 'users.id = orders.user_id')
                               ->findAll();
        
        // Set the filename
        $filename = 'payments_export_' . date('Y-m-d') . '.csv';
        
        // Set headers for CSV download
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        
        // Open the output stream
        $handle = fopen('php://output', 'w');
        
        // Add the CSV header row
        fputcsv($handle, [
            'ID', 
            'Order ID', 
            'Customer',
            'Amount', 
            'Payment Method',
            'Payment Date', 
            'Status',
            'Rental Start',
            'Rental End'
        ]);
        
        // Add data rows
        foreach ($payments as $payment) {
            // Fix payment method if needed
            if (empty($payment['payment_method']) && 
                (!empty($payment['bank_name']) || 
                !empty($payment['ewallet_provider']) || 
                !empty($payment['paylater_provider']) || 
                !empty($payment['minimarket_provider']))) {
                
                fix_payment_method($payment['id']);
                $payment = $this->paymentModel->find($payment['id']);
                
                // Ensure we have the related data that might have been lost
                if ($payment) {
                    $orderData = $this->orderModel->select('orders.start_date, orders.end_date, orders.total_price, users.name as user_name')
                        ->join('users', 'users.id = orders.user_id')
                        ->find($payment['order_id']);
                        
                    if ($orderData) {
                        $payment = array_merge($payment, $orderData);
                    }
                }
            }
            
            // Detect and format payment method
            $paymentMethodData = detect_payment_method($payment);
            $paymentMethodText = !empty($paymentMethodData['method']) ? 
                format_payment_method($paymentMethodData) : '-';
            
            fputcsv($handle, [
                $payment['id'],
                $payment['order_id'],
                $payment['user_name'],
                'Rp ' . number_format($payment['total_price'], 0, ',', '.'),
                $paymentMethodText,
                !empty($payment['payment_date']) ? date('d M Y', strtotime($payment['payment_date'])) : '-',
                ucfirst($payment['status'] ?? 'pending'),
                date('d M Y', strtotime($payment['start_date'])),
                date('d M Y', strtotime($payment['end_date']))
            ]);
        }
        
        // Close the file handle
        fclose($handle);
        exit;
    }
}
