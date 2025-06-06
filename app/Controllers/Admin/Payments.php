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
    
    public function exportCsv()
    {
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
            fputcsv($handle, [
                $payment['id'],
                $payment['order_id'],
                $payment['user_name'],
                'Rp ' . number_format($payment['total_price'], 0, ',', '.'),
                ucfirst(str_replace('_', ' ', $payment['payment_method'] ?? '-')),
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
