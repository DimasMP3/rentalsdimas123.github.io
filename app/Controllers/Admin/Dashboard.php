<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;
use App\Models\Admin\DashboardModel;
use App\Models\Admin\UserManagementModel;
use App\Models\Admin\PaymentManagementModel;

class Dashboard extends BaseController
{
    protected $dashboardModel;
    protected $userModel;
    protected $paymentModel;
    
    public function __construct()
    {
        $this->dashboardModel = new DashboardModel();
        $this->userModel = new UserManagementModel();
        $this->paymentModel = new PaymentManagementModel();
    }
    
    public function index()
    {
        $statistics = $this->dashboardModel->getDashboardStatistics();
        $topRentedCars = $this->dashboardModel->getTopRentedCars();
        $recentPayments = $this->dashboardModel->getRecentPayments();
        
        $data = [
            'title' => 'Admin Dashboard',
            'statistics' => $statistics,
            'top_rented_cars' => $topRentedCars,
            'recent_payments' => $recentPayments
        ];
        
        return view('admin/dashboard', $data);
    }
    
    public function users()
    {
        $data = [
            'title' => 'User Management',
            'users' => $this->userModel->getUsersWithRentalCount()
        ];
        
        return view('admin/users/index', $data);
    }
    
    public function userDetails($id)
    {
        $data = [
            'title' => 'User Details',
            'user_data' => $this->userModel->getUserDetails($id)
        ];
        
        return view('admin/users/detail', $data);
    }
    
    public function payments()
    {
        $data = [
            'title' => 'Payment Management',
            'payments' => $this->paymentModel->getAllPaymentsWithDetails()
        ];
        
        return view('admin/payments/index', $data);
    }
    
    public function paymentDetails($id)
    {
        $data = [
            'title' => 'Payment Details',
            'payment' => $this->paymentModel->getPaymentDetails($id)
        ];
        
        return view('admin/payments/detail', $data);
    }
    
    public function reports()
    {
        $currentYear = date('Y');
        
        $data = [
            'title' => 'Reports & Analytics',
            'monthly_revenue' => $this->paymentModel->getMonthlyRevenueReport($currentYear),
            'current_year' => $currentYear
        ];
        
        return view('admin/reports/index', $data);
    }
}

