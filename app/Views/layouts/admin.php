<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Panel' ?> - RentaldotSkuy</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #1e40af;
            --accent-color: #ff4d4d;
            --dark-bg: #212529;
            --dark-bg-lighter: #2c3136;
            --text-light: #f8f9fa;
            --text-muted: #6c757d;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            overflow-x: hidden;
        }
        
        .wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }
        
        #sidebar {
            min-width: 250px;
            max-width: 250px;
            background: linear-gradient(145deg, var(--dark-bg), var(--dark-bg-lighter));
            color: var(--text-light);
            transition: all 0.4s ease;
            box-shadow: 3px 0 15px rgba(0, 0, 0, 0.1);
            z-index: 999;
            position: fixed;
            height: 100vh;
        }
        
        #sidebar.active {
            margin-left: -250px;
        }
        
        #sidebar .sidebar-header {
            padding: 25px 20px;
            background: linear-gradient(145deg, var(--primary-color), var(--secondary-color));
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        #sidebar .sidebar-header h3 {
            margin: 0;
            font-weight: 700;
            letter-spacing: 1px;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        #sidebar ul.components {
            padding: 20px 0;
        }
        
        #sidebar ul li {
            margin-bottom: 5px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        #sidebar ul li:last-child {
            border-bottom: none;
        }
        
        #sidebar ul li a {
            padding: 12px 20px;
            font-size: 1.05em;
            display: block;
            color: var(--text-light);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 5px solid transparent;
            display: flex;
            align-items: center;
        }
        
        #sidebar ul li a i {
            margin-right: 10px;
            min-width: 25px;
            text-align: center;
        }
        
        #sidebar ul li a:hover {
            background: rgba(255, 255, 255, 0.08);
            color: white;
            border-left: 5px solid var(--primary-color);
        }
        
        #sidebar ul li.active > a {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left: 5px solid var(--primary-color);
            font-weight: 600;
        }
        
        #content {
            width: 100%;
            padding: 0;
            min-height: 100vh;
            transition: all 0.3s;
            background-color: #f5f7fa;
            margin-left: 250px;
        }
        
        .navbar {
            padding: 15px 20px;
            background: white;
            border: none;
            border-radius: 0;
            margin-bottom: 30px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            border-bottom: 1px solid #eaeaea;
        }
        
        #sidebarCollapse {
            background: transparent;
            color: var(--dark-bg);
            border: none;
            font-size: 1.2rem;
            transition: all 0.3s;
            outline: none !important;
            box-shadow: none !important;
        }
        
        #sidebarCollapse:hover {
            color: var(--primary-color);
            transform: scale(1.1);
        }
        
        .navbar .nav-link {
            color: var(--dark-bg) !important;
            padding: 8px 15px !important;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }
        
        .navbar .nav-link i {
            margin-right: 6px;
        }
        
        .navbar .nav-link:hover {
            background-color: rgba(13, 110, 253, 0.1);
            color: var(--primary-color) !important;
            transform: translateY(-2px);
        }
        
        .container-fluid {
            padding: 0 30px 30px 30px;
        }
        
        .card {
            margin-bottom: 25px;
            border: none;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid #eaeaea;
            padding: 15px 20px;
            font-weight: 600;
        }
        
        .btn {
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.25);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(13, 110, 253, 0.35);
        }
        
        .page-title {
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--dark-bg);
            border-left: 4px solid var(--primary-color);
            padding-left: 15px;
        }
        
        .breadcrumb {
            padding: 0;
            margin-bottom: 20px;
            background: transparent;
        }
        
        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .breadcrumb-item.active {
            color: var(--text-muted);
        }
        
        .table {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .table thead th {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 12px 15px;
        }
        
        .table tbody tr {
            transition: all 0.3s ease;
        }
        
        .table tbody tr:hover {
            background-color: rgba(13, 110, 253, 0.05);
            transform: scale(1.01);
        }
        
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -250px;
            }
            #sidebar.active {
                margin-left: 0;
            }
            #content {
                margin-left: 0;
            }
            #content.active {
                margin-left: 250px;
            }
            .navbar {
                padding: 10px 15px;
            }
            .container-fluid {
                padding: 0 15px 15px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header text-center">
                <h3>Admin Panel</h3>
            </div>

            <ul class="list-unstyled components">
                <li class="<?= strpos(current_url(), 'admin/dashboard') !== false ? 'active' : '' ?>">
                    <a href="<?= site_url('admin/dashboard') ?>">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="<?= strpos(current_url(), 'admin/users') !== false ? 'active' : '' ?>">
                    <a href="<?= site_url('admin/users') ?>">
                        <i class="fas fa-users"></i> Pengguna
                    </a>
                </li>
                <li class="<?= strpos(current_url(), 'admin/cars') !== false ? 'active' : '' ?>">
                    <a href="<?= site_url('admin/cars') ?>">
                        <i class="fas fa-car"></i> Mobil
                    </a>
                </li>
                <li class="<?= strpos(current_url(), 'admin/orders') !== false ? 'active' : '' ?>">
                    <a href="<?= site_url('admin/orders') ?>">
                        <i class="fas fa-shopping-cart"></i> Pesanan
                    </a>
                </li>
                <li class="<?= strpos(current_url(), 'admin/reviews') !== false ? 'active' : '' ?>">
                    <a href="<?= site_url('admin/reviews') ?>">
                        <i class="fas fa-star"></i> Ulasan
                    </a>
                </li>
                <li class="<?= strpos(current_url(), 'admin/settings') !== false ? 'active' : '' ?>">
                    <a href="<?= site_url('admin/settings') ?>">
                        <i class="fas fa-cog"></i> Pengaturan
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid px-0">
                    <button type="button" id="sidebarCollapse" class="btn">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <div class="d-flex align-items-center">
                        <ul class="nav navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url() ?>">
                                    <i class="fas fa-home"></i> Halaman Utama
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle"></i> <?= session()->get('name') ?? 'Admin' ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="<?= site_url('admin/profile') ?>">
                                            <i class="fas fa-user me-2 text-primary"></i> Profil
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= site_url('logout') ?>">
                                            <i class="fas fa-sign-out-alt me-2 text-danger"></i> Logout
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="container-fluid">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
    <!-- Custom JS -->
    <script>
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
                $('#content').toggleClass('active');
            });
            
            // Initialize DataTables if present
            if ($.fn.DataTable && $('table.data-table').length) {
                $('table.data-table').DataTable({
                    responsive: true,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Cari data...",
                        lengthMenu: "Tampilkan _MENU_ data per halaman",
                        zeroRecords: "Tidak ada data yang ditemukan",
                        info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                        infoEmpty: "Tidak ada data tersedia",
                        infoFiltered: "(disaring dari _MAX_ total data)",
                        paginate: {
                            first: "Pertama",
                            last: "Terakhir",
                            next: "Selanjutnya",
                            previous: "Sebelumnya"
                        }
                    }
                });
            }
        });
    </script>
</body>
</html> 