<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - RentaldotSkuy' : 'RentaldotSkuy - Rental Mobil Premium Indonesia' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --accent-color: #f72585;
            --text-color: #2b2d42;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --gray-color: #6c757d;
            --light-gray: #e9ecef;
            --gradient-start: #4361ee;
            --gradient-end: #3a0ca3;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            padding-top: 72px;
            background-color: #fafafa;
            color: var(--text-color);
        }
        
        /* ===== Header Styling ===== */
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            padding: 4px 0;
            transition: all 0.4s ease;
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
        }
        
        .navbar.scrolled {
            padding: 2px 0;
            background: rgba(255, 255, 255, 0.98) !important;
            box-shadow: 0 3px 20px rgba(0, 0, 0, 0.08);
        }
        
        .navbar-brand {
            font-weight: 700;
            display: flex;
            align-items: center;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .navbar-brand::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent-color);
            transition: all 0.3s ease;
        }
        
        .navbar-brand:hover::after {
            width: 100%;
        }
        
        .navbar-brand img {
            height: 32px;
            transition: all 0.3s ease;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }
        
        .navbar.scrolled .navbar-brand img {
            height: 28px;
        }
        
        .nav-item {
            position: relative;
            margin: 0 1px;
        }
        
        .nav-link {
            color: var(--text-color) !important;
            font-weight: 500;
            padding: 6px 10px !important;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 0;
            background-color: rgba(67, 97, 238, 0.08);
            border-radius: 8px;
            z-index: -1;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            color: var(--primary-color) !important;
            transform: translateY(-1px);
        }
        
        .nav-link:hover::before {
            height: 100%;
        }
        
        .nav-link.active {
            color: var(--primary-color) !important;
            background-color: rgba(67, 97, 238, 0.08);
            font-weight: 600;
        }
        
        .nav-link.active::before {
            height: 100%;
            background-color: rgba(67, 97, 238, 0.12);
        }
        
        .dropdown-menu {
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            padding: 0.6rem 0;
            margin-top: 8px;
            animation: fadeIn 0.2s ease-in-out;
            border-top: 3px solid var(--accent-color);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .dropdown-item {
            padding: 8px 20px;
            color: var(--text-color);
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            font-size: 0.9rem;
        }
        
        .dropdown-item:hover {
            background-color: rgba(67, 97, 238, 0.05);
            color: var(--primary-color);
            padding-left: 24px;
        }
        
        .dropdown-item:active, .dropdown-item:focus {
            background-color: var(--primary-color);
            color: white;
        }

        .auth-buttons {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .lang-selector {
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 20px;
            padding: 4px 10px;
            font-size: 0.85rem;
            background-color: transparent;
            transition: all 0.3s ease;
            cursor: pointer;
            color: var(--text-color);
        }
        
        .lang-selector:hover {
            border-color: var(--primary-color);
            box-shadow: 0 2px 6px rgba(67, 97, 238, 0.15);
        }
        
        .btn-primary-outline {
            color: var(--primary-color) !important;
            border: 1.5px solid var(--primary-color);
            border-radius: 50px;
            padding: 6px 18px !important;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }
        
        .btn-primary-outline::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background-color: var(--primary-color);
            z-index: -1;
            transition: all 0.3s ease;
            border-radius: 50px;
        }
        
        .btn-primary-outline:hover {
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 5px 12px rgba(67, 97, 238, 0.25);
        }
        
        .btn-primary-outline:hover::before {
            width: 100%;
        }
        
        .btn-primary-solid {
            background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
            color: white !important;
            border-radius: 50px;
            padding: 7px 20px !important;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
            border: none;
            position: relative;
            overflow: hidden;
            z-index: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }
        
        .btn-primary-solid::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 0;
            background: linear-gradient(135deg, var(--gradient-end) 0%, var(--gradient-start) 100%);
            z-index: -1;
            transition: all 0.3s ease;
            border-radius: 50px;
        }

        .btn-primary-solid:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(67, 97, 238, 0.3);
        }
        
        .btn-primary-solid:hover::before {
            height: 100%;
        }

        .btn-accent {
            background: linear-gradient(135deg, var(--accent-color) 0%, #e5007e 100%);
            color: white !important;
            border-radius: 50px;
            padding: 9px 24px !important;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(247, 37, 133, 0.25);
            border: none;
        }
        
        .btn-accent:hover {
            background: linear-gradient(135deg, #e5007e 0%, var(--accent-color) 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(247, 37, 133, 0.35);
        }
        
        .user-menu {
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .user-menu .nav-link {
            display: flex;
            align-items: center;
            padding: 4px 10px !important;
        }
        
        .user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin-right: 8px;
            box-shadow: 0 3px 8px rgba(67, 97, 238, 0.2);
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.85);
            font-size: 0.85rem;
        }
        
        .user-menu:hover .user-avatar {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
        }
        
        .user-name {
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }
        
        .user-menu:hover .user-name {
            color: var(--primary-color);
        }
        
        /* Footer adjustments */
        footer {
            margin-top: 40px;
            background: linear-gradient(to right, #212529, #343a40);
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.05);
        }
        
        footer h5 {
            position: relative;
            display: inline-block;
            margin-bottom: 1.5rem;
            font-weight: 700;
        }
        
        footer h5:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -8px;
            width: 40px;
            height: 3px;
            background: var(--accent-color);
        }
        
        .footer-brand {
            position: relative;
            margin-bottom: 20px;
        }
        
        .contact-info {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .contact-info li {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1.2rem;
        }
        
        .contact-info li i {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--accent-color);
        }
        
        .contact-info li p {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.6);
        }
        
        .contact-link {
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .contact-link:hover {
            color: var(--accent-color);
        }
        
        .footer-section {
            padding: 60px 0 30px;
            background: #000000;
            color: rgba(255, 255, 255, 0.8);
        }
        
        .footer-heading {
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer-heading:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 30px;
            height: 2px;
            background: var(--accent-color);
        }
        
        .footer-desc {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 20px;
            line-height: 1.7;
        }
        
        .contact-info-mini {
            margin-bottom: 20px;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .contact-item i {
            color: var(--accent-color);
            margin-right: 10px;
            width: 20px;
        }
        
        .contact-item span {
            color: rgba(255, 255, 255, 0.9);
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-links li {
            margin-bottom: 12px;
        }
        
        .footer-links li a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            padding-left: 0;
        }
        
        .footer-links li a:before {
            content: '›';
            position: absolute;
            left: -12px;
            opacity: 0;
            color: var(--accent-color);
            transition: all 0.3s ease;
        }

        .footer-links li a:hover {
            color: white;
            padding-left: 12px;
        }
        
        .footer-links li a:hover:before {
            opacity: 1;
            left: 0;
        }
        
        .hours-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .hours-list li {
            display: flex;
            justify-content: space-between;
            color: rgba(255, 255, 255, 0.7);
            padding: 8px 0;
            border-bottom: 1px dashed rgba(255, 255, 255, 0.1);
        }
        
        .footer-bottom {
            margin-top: 40px;
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .social-links {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 18px;
        }
        
        .social-link:hover {
            background: var(--accent-color);
            color: white;
            transform: translateY(-3px);
        }
        
        .btn-whatsapp {
            display: inline-flex;
            align-items: center;
            background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
            color: white;
            padding: 10px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(37, 211, 102, 0.3);
        }
        
        .btn-whatsapp:hover {
            background: linear-gradient(135deg, #128C7E 0%, #25D366 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(37, 211, 102, 0.4);
        }
        
        .copyright {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
            margin-bottom: 0;
        }
        
        .navbar-toggler {
            border: none;
            padding: 0.25rem 0.5rem;
            font-size: 1rem;
            border-radius: 5px;
            transition: all 0.3s ease;
            background-color: rgba(13, 110, 253, 0.08);
        }
        
        .navbar-toggler:focus {
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.25);
            outline: none;
        }
        
        .navbar-toggler-icon {
            width: 1.25em;
            height: 1.25em;
        }
        
        @media (max-width: 992px) {
            .nav-link {
                padding: 8px 15px !important;
                margin: 2px 0;
            }
            
            .auth-buttons {
                margin-top: 10px;
                justify-content: center;
                flex-wrap: wrap;
                gap: 6px;
            }
            
            .navbar-brand img {
                height: 30px;
            }
            
            body {
                padding-top: 70px;
            }
            
            .dropdown-menu {
                margin-top: 0;
                border-top: 2px solid var(--primary-color);
            }
            
            .user-menu {
                width: 100%;
                justify-content: center;
                margin-top: 5px;
            }
            
            .user-menu .nav-link {
                justify-content: center;
            }
            
            .btn-primary-outline, .btn-primary-solid {
                width: 100%;
                justify-content: center;
                text-align: center;
            }
            
            .lang-selector {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top">
            <div class="container">
                <a class="navbar-brand" href="<?= site_url() ?>">
                    <img src="<?= base_url('assets/images/logorental.png') ?>" alt="RentaldotSkuy">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link <?= (current_url() == base_url() || current_url() == base_url('index.php')) ? 'active' : '' ?>" href="<?= site_url() ?>">
                                <i class="fas fa-home me-1"></i> Beranda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(current_url(), 'about') !== false ? 'active' : '' ?>" href="<?= site_url('about') ?>">
                                <i class="fas fa-info-circle me-1"></i> Tentang Kami
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(current_url(), 'cars') !== false ? 'active' : '' ?>" href="<?= site_url('cars') ?>">
                                <i class="fas fa-car me-1"></i> Daftar Mobil
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-concierge-bell me-1"></i> Layanan
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-car-side me-2 text-primary"></i>Rental Mobil</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user-tie me-2 text-primary"></i>Rental + Supir (Belum Tersedia)</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-route me-2 text-primary"></i>Drop Off (Belum Tersedia)</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(current_url(), 'gallery') !== false ? 'active' : '' ?>" href="<?= site_url('gallery') ?>">
                                <i class="fas fa-images me-1"></i> Gallery
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(current_url(), 'blog') !== false ? 'active' : '' ?>" href="<?= site_url('blog') ?>">
                                <i class="fas fa-newspaper me-1"></i> Blog
                            </a>
                        </li>
                    </ul>
                    
                    <div class="d-flex align-items-center auth-buttons">
                        <select class="lang-selector me-3">
                            <option value="id">ID</option>
                            <option value="en">EN</option>
                        </select>
                        
                        <?php if(session()->has('isLoggedIn') && session()->get('isLoggedIn')): ?>
                            <?php if(session()->has('role') && session()->get('role') === 'admin'): ?>
                                <a href="<?= site_url('admin/dashboard') ?>" class="btn-primary-outline">
                                    <i class="fas fa-user-shield me-1"></i> Admin Panel
                                </a>
                            <?php else: ?>
                                <div class="dropdown user-menu">
                                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                        <div class="user-avatar">
                                            <?= substr(session()->get('name'), 0, 1) ?>
                                        </div>
                                        <span class="user-name"><?= session()->get('name') ?></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="<?= site_url('rentals') ?>">
                                                <i class="fas fa-calendar-check me-2 text-primary"></i> Pesanan Saya
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="<?= site_url('profile') ?>">
                                                <i class="fas fa-user-circle me-2 text-primary"></i> Profil
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item" href="<?= site_url('logout') ?>">
                                                <i class="fas fa-sign-out-alt me-2 text-danger"></i> Logout
                                            </a>
                                        </li>
                            </ul>
                        </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <a href="<?= site_url('login') ?>" class="btn-primary-outline me-2">
                                <i class="fas fa-sign-in-alt me-1"></i> Login
                            </a>
                            <a href="<?= site_url('register') ?>" class="btn-primary-solid">
                                <i class="fas fa-user-plus me-1"></i> Daftar
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    
    <!-- Main Content -->
    <?= $this->renderSection('content') ?>
    
    <!-- Footer -->
    <?php 
    // Hide footer on pages that set $hideFooter = true
    if (!isset($hideFooter) || $hideFooter !== true): 
    ?>
    <footer class="footer-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="footer-brand">
                        <img src="<?= base_url('assets/images/logorental.png') ?>" alt="RentaldotSkuy" class="mb-3" style="height: 38px;">
                    </div>
                    <p class="footer-desc">RentaldotSkuy adalah layanan rental mobil premium dengan armada berkualitas dan pelayanan profesional untuk memenuhi kebutuhan transportasi Anda.</p>
                    <div class="contact-info-mini">
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <span>083896297994</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i> 
                            <span>info@rentaldotskuy.com</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="footer-heading">Navigasi</h5>
                    <ul class="footer-links">
                        <li><a href="<?= site_url() ?>">Beranda</a></li>
                        <li><a href="<?= site_url('cars') ?>">Daftar Mobil</a></li>
                        <li><a href="<?= site_url('about') ?>">Tentang Kami</a></li>
                        <li><a href="<?= site_url('gallery') ?>">Gallery</a></li>
                        <li><a href="<?= site_url('blog') ?>">Blog</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="footer-heading">Layanan Kami</h5>
                    <ul class="footer-links">
                        <li><a href="#">Rental Harian</a></li>
                        <li><a href="#">Rental + Supir (Belum Tersedia)</a></li>
                        <li><a href="#">Antar-Jemput Bandara (Belum Tersedia)</a></li>
                        <li><a href="#">Drop Off (Belum Tersedia)</a></li>
                        <li><a href="#">Paket Wisata (Belum Tersedia)</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="footer-heading">Jam Operasional</h5>
                    <ul class="hours-list">
                        <li>
                            <span>Senin - Jumat</span>
                            <span>08:00 - 20:00</span>
                        </li>
                        <li>
                            <span>Sabtu</span>
                            <span>08:00 - 18:00</span>
                        </li>
                        <li>
                            <span>Minggu</span>
                            <span>09:00 - 15:00</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="social-links">
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-tiktok"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                </div>
                <p class="copyright">&copy; <?= date('Y') ?> RentaldotSkuy. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <?php endif; ?>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Dropdown hover effect for desktop
        if (window.innerWidth > 992) {
            document.querySelectorAll('.dropdown').forEach(function(dropdown) {
                dropdown.addEventListener('mouseenter', function() {
                    this.querySelector('.dropdown-toggle').click();
                });
                
                dropdown.addEventListener('mouseleave', function() {
                    this.querySelector('.dropdown-toggle').click();
                });
            });
        }
    </script>
</body>
</html>
