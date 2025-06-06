<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Dashboard' ?> | Rental Mobil</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url('assets/img/favicon.ico') ?>" type="image/x-icon">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <link href="<?= base_url('assets/css/admin.css') ?>" rel="stylesheet">
    
    <!-- Datatables CSS -->
    <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <?= $this->renderSection('styles') ?>
</head>
<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= site_url('admin/dashboard') ?>">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-car"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Rental Mobil</div>
            </a>
            
            <hr class="sidebar-divider my-0">
            
            <li class="nav-item <?= uri_string() == 'admin/dashboard' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= site_url('admin/dashboard') ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <hr class="sidebar-divider">
            
            <div class="sidebar-heading">
                Manajemen Data
            </div>
            
            <li class="nav-item <?= strpos(uri_string(), 'admin/cars') === 0 ? 'active' : '' ?>">
                <a class="nav-link" href="<?= site_url('admin/cars') ?>">
                    <i class="fas fa-fw fa-car"></i>
                    <span>Mobil</span>
                </a>
            </li>
            
            <li class="nav-item <?= strpos(uri_string(), 'admin/rentals') === 0 ? 'active' : '' ?>">
                <a class="nav-link" href="<?= site_url('admin/rentals') ?>">
                    <i class="fas fa-fw fa-clipboard-list"></i>
                    <span>Penyewaan</span>
                </a>
            </li>
            
            <li class="nav-item <?= strpos(uri_string(), 'admin/users') === 0 ? 'active' : '' ?>">
                <a class="nav-link" href="<?= site_url('admin/users') ?>">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Customer</span>
                </a>
            </li>
            
            <li class="nav-item <?= strpos(uri_string(), 'admin/payments') === 0 ? 'active' : '' ?>">
                <a class="nav-link" href="<?= site_url('admin/payments') ?>">
                    <i class="fas fa-fw fa-credit-card"></i>
                    <span>Pembayaran</span>
                </a>
            </li>
            
            <li class="nav-item <?= strpos(uri_string(), 'admin/reviews') === 0 ? 'active' : '' ?>">
                <a class="nav-link" href="<?= site_url('admin/reviews') ?>">
                    <i class="fas fa-fw fa-star"></i>
                    <span>Ulasan</span>
                </a>
            </li>
            
            <hr class="sidebar-divider">
            
            <div class="sidebar-heading">
                Laporan
            </div>
            
            <li class="nav-item <?= strpos(uri_string(), 'admin/reports') === 0 ? 'active' : '' ?>">
                <a class="nav-link" href="<?= site_url('admin/reports') ?>">
                    <i class="fas fa-fw fa-chart-bar"></i>
                    <span>Laporan & Analisis</span>
                </a>
            </li>
            
            <hr class="sidebar-divider d-none d-md-block">
            
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->
        
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    
                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Cari..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>
                        
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= session('name') ?></span>
                                <img class="img-profile rounded-circle" src="<?= base_url('assets/img/user.jpg') ?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= site_url('admin/profile') ?>">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profil
                                </a>
                                <a class="dropdown-item" href="<?= site_url('admin/settings') ?>">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Pengaturan
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Keluar
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->
                
                <!-- Begin Page Content -->
                <?= $this->renderSection('content') ?>
                <!-- End of Page Content -->
            </div>
            
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Rental Mobil <?= date('Y') ?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yakin ingin keluar?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Pilih "Keluar" jika anda ingin mengakhiri sesi anda.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a class="btn btn-primary" href="<?= site_url('logout') ?>">Keluar</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap core JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Core plugin JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-easing@0.0.1/dist/jquery.easing.min.js"></script>
    
    <!-- Datatables JavaScript -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- Custom scripts for all pages -->
    <script src="<?= base_url('assets/js/admin.js') ?>"></script>
    
    <script>
        $(document).ready(function() {
            $('.dataTable').DataTable();
        });
    </script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html> 