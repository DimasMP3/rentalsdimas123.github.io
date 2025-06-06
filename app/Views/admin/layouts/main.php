<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - CarRent Admin' : 'CarRent Admin Dashboard' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-dark text-white" id="sidebar-wrapper">
            <div class="sidebar-heading p-3">
                <i class="fas fa-car-side me-2"></i>
                CarRent Admin
            </div>
            <div class="list-group list-group-flush">
                <a href="<?= site_url('admin/dashboard') ?>" class="list-group-item list-group-item-action bg-transparent text-white">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
                <a href="<?= site_url('admin/cars') ?>" class="list-group-item list-group-item-action bg-transparent text-white">
                    <i class="fas fa-car me-2"></i> Cars
                </a>
                <a href="<?= site_url('admin/categories') ?>" class="list-group-item list-group-item-action bg-transparent text-white">
                    <i class="fas fa-tags me-2"></i> Categories
                </a>
                <a href="<?= site_url('admin/rentals') ?>" class="list-group-item list-group-item-action bg-transparent text-white">
                    <i class="fas fa-calendar-check me-2"></i> Rentals
                </a>
                <a href="<?= site_url('admin/users') ?>" class="list-group-item list-group-item-action bg-transparent text-white">
                    <i class="fas fa-users me-2"></i> Users
                </a>
                <a href="<?= site_url('admin/payments') ?>" class="list-group-item list-group-item-action bg-transparent text-white">
                    <i class="fas fa-money-bill-wave me-2"></i> Payments
                </a>
                <a href="<?= site_url('admin/reports') ?>" class="list-group-item list-group-item-action bg-transparent text-white">
                    <i class="fas fa-chart-bar me-2"></i> Reports
                </a>
                <a href="<?= site_url('admin/settings') ?>" class="list-group-item list-group-item-action bg-transparent text-white">
                    <i class="fas fa-cog me-2"></i> Settings
                </a>
            </div>
        </div>
        
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user me-1"></i> <?= session()->get('name') ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="<?= site_url('admin/profile') ?>">My Profile</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?= site_url('logout') ?>">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            
            <!-- Flash Messages -->
            <?php if (session()->has('success')): ?>
            <div class="container-fluid mt-3">
                <div class="alert alert-success alert-dismissible fade show">
                    <?= session('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (session()->has('error')): ?>
            <div class="container-fluid mt-3">
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= session('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Main Content -->
            <?= $this->renderSection('content') ?>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="<?= base_url('assets/js/admin.js') ?>"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle sidebar
        const sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                document.getElementById('wrapper').classList.toggle('toggled');
            });
        }
    });
    </script>
</body>
</html>
