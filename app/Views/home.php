<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Hero Section with Carousel -->
<div class="hero-section">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="<?= base_url('assets/images/header-image.jpg') ?>" class="d-block w-100 h-100" alt="Slide 1">
            </div>
            <div class="carousel-item">
                <img src="<?= base_url('assets/images/header-image2-rev.jpg') ?>" class="d-block w-100 h-100" alt="Slide 2">
            </div>
            <div class="carousel-item">
                <img src="<?= base_url('assets/images/header-image3-rev.jpg') ?>" class="d-block w-100 h-100" alt="Slide 3">
            </div>  
        </div>
    </div>
    
    <!-- Overlay tetap -->
    <div class="static-overlay"></div>
    
    <div class="hero-content">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-md-6">
                    <div class="text-white">
                        <h1 class="display-4 fw-bold mb-4">Sewa Rental Mobil?<br>Ya Di RentalSkuy Aja!</h1>
                        <p class="lead mb-4">Berbagai Pilihan Mobil<br>Untuk Kebutuhan mu</p>
                        <a href="https://wa.me/083896297994" class="btn btn-danger btn-lg rounded-pill">
                            <i class="fab fa-whatsapp me-2"></i>Hubungi Kami: 083896297994
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <!-- Social Media Links -->
    <div class="social-links-container">
        <div class="social-links-wrapper">
            <a href="#" class="social-icon-link"><i class="fab fa-instagram"></i></a>
            <a href="#" class="social-icon-link"><i class="fab fa-tiktok"></i></a>
            <a href="#" class="social-icon-link"><i class="fab fa-facebook-f"></i></a>
        </div>
    </div>
</div>

<!-- Custom CSS -->
<style>
.hero-section {
    position: relative;
    height: 100vh;
    overflow: hidden;
}

#heroCarousel {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.carousel-inner {
    height: 100%;
}

.carousel-item {
    height: 100%;
}

.carousel-item img {
    object-fit: cover;
    height: 100vh;
    width: 100%;
}

.static-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.4);
    z-index: 1;
}

.hero-content {
    position: relative;
    height: 100%;
    z-index: 2;
}

.hero-content .text-white {
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
}

/* Service Icons Styling */
.service-icons-container {
    position: absolute;
    bottom: 100px;
    left: 0;
    right: 0;
    z-index: 3;
}

.service-icons {
    background-color: rgba(255, 255, 255, 0.95);
    border-radius: 15px;
    display: flex;
    justify-content: space-around;
    padding: 20px 10px;
    max-width: 800px;
    margin: 0 auto;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.service-icon {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    width: 20%;
}

.icon-wrapper {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f72585 0%, #e5007e 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 10px;
    color: white;
    font-size: 20px;
}

.service-icon span {
    font-size: 12px;
    font-weight: 600;
    color: #333;
}

/* Social Media Styling */
.social-links-container {
    position: absolute;
    bottom: 20px;
    left: 0;
    right: 0;
    z-index: 3;
    text-align: center;
}

.social-links-wrapper {
    display: inline-flex;
    background-color: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(5px);
    border-radius: 50px;
    padding: 8px 20px;
}

.social-icon-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    margin: 0 10px;
    border-radius: 50%;
    background-color: white;
    color: #333;
    text-decoration: none;
    font-size: 20px;
    transition: all 0.3s ease;
}

.social-icon-link:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    color: #333;
}

.btn-danger {
    background-color: #dc3545;
    border: none;
    padding: 15px 30px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-danger:hover {
    background-color: #c82333;
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .service-icons {
        flex-wrap: wrap;
        padding: 15px 5px;
    }
    
    .service-icon {
        width: 33.33%;
        margin-bottom: 15px;
    }
    
    .icon-wrapper {
        width: 40px;
        height: 40px;
        font-size: 16px;
    }
    
    .service-icon span {
        font-size: 10px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var myCarousel = new bootstrap.Carousel(document.getElementById('heroCarousel'), {
        interval: 5000,
        ride: true
    });
});
</script>

<div class="container py-5">
    <div class="section-header text-center mb-5">
        <h2 class="fw-bold"> Rental Mobil</h2>
        <p class="text-muted">Dalam Dan Luar Kota</p>
        <div class="divider mx-auto my-3">
            <span class="divider-line"></span>
            <span class="divider-icon"><i class="fas fa-car"></i></span>
            <span class="divider-line"></span>
        </div>
    </div>

    <div class="position-relative car-showcase">
        <div id="carCarousel" class="carousel slide" data-bs-ride="carousel">
          
            <!-- Indicators/dots -->
            <div class="carousel-indicators">
                <?php 
              
                $chunks = array_chunk($featured_cars, 4);
                foreach ($chunks as $index => $chunk): 
                ?>
                <button type="button" data-bs-target="#carCarousel" data-bs-slide-to="<?= $index ?>" <?= $index === 0 ? 'class="active"' : '' ?> style="background-color: white;"></button>
                <?php endforeach; ?>
            </div>

            <div class="carousel-inner">
                <?php foreach ($chunks as $index => $chunk): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    <div class="row g-4">
                        <?php foreach ($chunk as $car): ?>
                        <div class="col-md-3">
                            <div class="car-card">
                                <div class="car-image-container">
                                    <div class="car-tag">Tersedia</div>
                                    <?php if(is_discount_day($car['id'])): 
                                        $discountPercentage = get_discount_percentage($car['id']);    
                                    ?>
                                    <div class="discount-badge">Diskon <?= number_format($discountPercentage, 0) ?>% Hari Ini!</div>
                                    <?php endif; ?>
                                    <img src="<?= base_url('uploads/cars/' . $car['image']) ?>" 
                                         class="car-image" 
                                         alt="<?= $car['brand'] . ' ' . $car['model'] ?>">
                                    <div class="car-overlay">
                                        <a href="<?= site_url('cars/' . $car['id']) ?>" class="btn-details">
                                            <i class="fas fa-info-circle me-1"></i> Detail
                                        </a>
                                    </div>
                                </div>
                                <div class="car-info">
                                    <h5 class="car-title"><?= $car['brand'] . ' ' . $car['model'] ?></h5>
                                    <div class="price-info">
                                        <div class="price-item">
                                            <span class="price-label">24 jam dalam/luar kota</span>
                                            <?php if(is_discount_day($car['id'])): ?>
                                            <span class="price-value">
                                                <span class="original-price">Rp <?= number_format($car['daily_rate'] * 0.5, 0, ',', '.') ?></span>
                                                Rp <?= number_format(get_discounted_price($car, 0.5), 0, ',', '.') ?>
                                            </span>
                                            <?php else: ?>
                                            <span class="price-value">Rp <?= number_format($car['daily_rate'] * 0.5, 0, ',', '.') ?> - Rp <?= number_format($car['daily_rate'] * 0.75, 0, ',', '.') ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="price-item">
                                            <span class="price-label">Harian + Supir</span>
                                            <?php if(is_discount_day($car['id'])): ?>
                                            <span class="price-value">
                                                <span class="original-price">Rp <?= number_format($car['daily_rate'], 0, ',', '.') ?></span>
                                                Rp <?= number_format(get_discounted_price($car, 1), 0, ',', '.') ?>
                                            </span>
                                            <?php else: ?>
                                            <span class="price-value">Rp <?= number_format($car['daily_rate'] * 0.75, 0, ',', '.') ?> - Rp <?= number_format($car['daily_rate'], 0, ',', '.') ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="price-item">
                                            <span class="price-label">Monthly</span>
                                            <?php if(is_discount_day($car['id'])): ?>
                                            <span class="price-value price-highlight">
                                                <span class="original-price">Rp <?= number_format($car['daily_rate'] * 30 * 0.8, 0, ',', '.') ?></span>
                                                Rp <?= number_format(get_discounted_price($car, 30 * 0.8), 0, ',', '.') ?>
                                            </span>
                                            <?php else: ?>
                                            <span class="price-value price-highlight">Rp <?= number_format($car['daily_rate'] * 30 * 0.8, 0, ',', '.') ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <a href="<?= site_url('cars/' . $car['id']) ?>" class="detail-button">
                                    <i class="fas fa-info-circle"></i> Pesan
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Navigation buttons -->
            <button class="carousel-control carousel-control-prev" type="button" data-bs-target="#carCarousel" data-bs-slide="prev">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="carousel-control carousel-control-next" type="button" data-bs-target="#carCarousel" data-bs-slide="next">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>

    <!-- View All Cars Button -->
    <div class="text-center mt-4">
        <a href="<?= site_url('cars') ?>" class="view-all-btn">
            <span>Lihat Semua Mobil</span>
            <i class="fas fa-arrow-right ms-2"></i>
        </a>
    </div>
</div>

<style>
    .section-header h2 {
        color: var(--text-color);
        font-size: 2rem;
        position: relative;
    }
    
    .divider {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 200px;
    }
    
    .divider-line {
        height: 1px;
        flex-grow: 1;
        background-color: rgba(0, 0, 0, 0.1);
    }
    
    .divider-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
        color: white;
        margin: 0 15px;
        box-shadow: 0 3px 10px rgba(67, 97, 238, 0.2);
    }
    
    .car-showcase {
        padding: 10px;
    }
    
    .car-card {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        background-color: white;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .car-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
    
    .car-image-container {
        position: relative;
        height: 180px; /* Fixed height instead of aspect ratio */
        overflow: hidden;
        border-radius: 12px 12px 0 0;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .car-image {
        max-width: 100%;
        max-height: 100%;
        width: auto;
        height: auto;
        object-fit: contain;
        padding: 10px;
        transition: transform 0.3s ease;
    }
    
    .car-card:hover .car-image {
        transform: scale(1.05);
    }
    
    .car-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.3s ease;
    }
    
    .car-card:hover .car-overlay {
        opacity: 1;
    }
    
    .btn-details {
        background-color: white;
        color: var(--text-color);
        padding: 8px 16px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .btn-details:hover {
        background-color: var(--primary-color);
        color: white;
    }
    
    .car-tag {
        position: absolute;
        top: 15px;
        left: 15px;
        background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
        color: white;
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        z-index: 1;
        box-shadow: 0 3px 8px rgba(34, 197, 94, 0.3);
    }
    
    .car-info {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    .car-title {
        font-weight: 700;
        font-size: 1.15rem;
        margin-bottom: 15px;
        color: var(--text-color);
        text-align: center;
    }
    
    .price-info {
        margin-bottom: 15px;
        flex-grow: 1;
    }
    
    .price-item {
        display: flex;
        justify-content: space-between;
        padding: 6px 0;
        border-bottom: 1px dashed rgba(0, 0, 0, 0.06);
    }
    
    .price-item:last-child {
        border-bottom: none;
    }
    
    .price-label {
        color: var(--gray-color);
        font-size: 0.85rem;
    }
    
    .price-value {
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .price-highlight {
        color: var(--primary-color);
        font-weight: 700;
    }
    
    .detail-button {
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--gradient-end) 100%);
        color: white;
        padding: 10px 15px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        margin-top: 15px;
        width: 100%;
        gap: 8px;
        text-align: center;
    }
    
    .detail-button i {
        font-size: 1rem;
    }
    
    .detail-button:hover {
        background: linear-gradient(135deg, var(--gradient-end) 0%, var(--primary-color) 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.25);
    }
    
    .btn-booking {
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        color: white;
        padding: 10px 15px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        margin-top: auto;
    }
    
    .btn-booking:hover {
        background: linear-gradient(135deg, #16a34a 0%, #22c55e 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.25);
    }
    
    .carousel-control {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: white;
        top: 45%;
        color: var(--text-color);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0.8;
        transition: all 0.3s ease;
    }
    
    .carousel-control:hover {
        background-color: var(--primary-color);
        color: white;
        opacity: 1;
    }
    
    .carousel-control-prev {
        left: -16px;
    }
    
    .carousel-control-next {
        right: -16px;
    }
    
    .carousel-indicators {
        bottom: -35px;
    }
    
    .carousel-indicators button {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: rgba(67, 97, 238, 0.3);
        border: none;
        margin: 0 5px;
    }
    
    .carousel-indicators button.active {
        background-color: var(--primary-color);
    }
    
    .view-all-btn {
        display: inline-flex;
        align-items: center;
        background-color: var(--light-gray);
        color: var(--text-color);
        padding: 10px 25px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-top: 40px;
    }
    
    .view-all-btn:hover {
        background-color: var(--primary-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(67, 97, 238, 0.2);
    }
    
    @media (max-width: 768px) {
        .car-card {
            margin-bottom: 15px;
        }
        
        .carousel-control {
            display: none;
        }
    }
    
    .discount-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5253 100%);
        color: white;
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        z-index: 1;
        box-shadow: 0 3px 8px rgba(238, 82, 83, 0.3);
        animation: pulse 1.5s infinite;
    }
    
    .original-price {
        text-decoration: line-through;
        color: #999;
        font-size: 0.8rem;
        display: block;
    }
    
    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
        100% {
            transform: scale(1);
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var carCarousel = new bootstrap.Carousel(document.getElementById('carCarousel'), {
        interval: 5000,
        wrap: true,
        touch: true
    });

    // Menambahkan event listener untuk tombol next/prev
    document.querySelector('.carousel-control-next').addEventListener('click', function() {
        carCarousel.next();
    });

    document.querySelector('.carousel-control-prev').addEventListener('click', function() {
        carCarousel.prev();
    });

    // Menambahkan event listener untuk indikator
    document.querySelectorAll('.carousel-indicators button').forEach(function(button) {
        button.addEventListener('click', function() {
            var slideIndex = this.getAttribute('data-bs-slide-to');
            carCarousel.to(parseInt(slideIndex));
        });
    });

    // Menambahkan touch support untuk mobile
    let touchStartX = 0;
    let touchEndX = 0;
    
    const carouselElement = document.getElementById('carCarousel');
    
    carouselElement.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
    }, false);
    
    carouselElement.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    }, false);
    
    function handleSwipe() {
        if (touchEndX < touchStartX) {
            carCarousel.next();
        }
        if (touchEndX > touchStartX) {
            carCarousel.prev();
        }
    }
});
</script>

<div class="why-choose-us py-5">
    <div class="container">
        <div class="section-title text-center mb-5">
            <span class="badge rounded-pill">KEUNGGULAN KAMI</span>
            <h2 class="display-5 fw-bold mt-3">Mengapa Memilih Kami</h2>
            <p class="lead opacity-75">Pengalaman sewa mobil terbaik dan terpercaya</p>
        </div>

        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="feature-item">
                    <div class="feature-icon">
                        <div class="icon-bg">
                            <i class="fas fa-car"></i>
                        </div>
                        <div class="feature-number">01</div>
                    </div>
                    <div class="feature-content">
                        <h4>Pilihan Lengkap</h4>
                        <p>Berbagai jenis mobil tersedia untuk memenuhi kebutuhan Anda, dari ekonomis hingga premium.</p>
                        <div class="feature-line"></div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4">
                <div class="feature-item">
                    <div class="feature-icon">
                        <div class="icon-bg">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="feature-number">02</div>
                    </div>
                    <div class="feature-content">
                        <h4>Harga Terbaik</h4>
                        <p>Harga bersaing tanpa biaya tersembunyi. Dapatkan nilai lebih untuk setiap rupiah yang Anda belanjakan.</p>
                        <div class="feature-line"></div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4">
                <div class="feature-item">
                    <div class="feature-icon">
                        <div class="icon-bg">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div class="feature-number">03</div>
                    </div>
                    <div class="feature-content">
                        <h4>Layanan 24/7</h4>
                        <p>Tim kami siap membantu Anda kapan saja. Dukungan pelanggan selalu tersedia 24 jam setiap hari.</p>
                        <div class="feature-line"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="https://wa.me/083896297994" class="btn btn-cta">
                    <i class="fab fa-whatsapp me-2"></i>Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.why-choose-us {
    background-color: #ffffff;
    color: #333;
    position: relative;
    overflow: hidden;
}

.why-choose-us::before {
    content: "";
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(0,0,0,0.02) 0%, rgba(0,0,0,0) 70%);
    z-index: 0;
}

.section-title .badge {
    background: linear-gradient(45deg, #ff4d4d, #f9004d);
    color: white;
    font-size: 0.8rem;
    padding: 8px 16px;
    letter-spacing: 1px;
}

.feature-item {
    display: flex;
    background-color: #f8f9fa;
    border-radius: 15px;
    overflow: hidden;
    transition: all 0.4s ease;
    height: 100%;
    position: relative;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
}

.feature-item:hover {
    transform: translateY(-8px);
    background-color: #ffffff;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}

.feature-item:hover .icon-bg {
    background: linear-gradient(45deg, #ff4d4d, #f9004d);
}

.feature-icon {
    padding: 25px;
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 120px;
    border-right: 1px solid rgba(0,0,0,0.07);
}

.icon-bg {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background-color: rgba(0,0,0,0.05);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    margin-bottom: 20px;
    transition: all 0.4s ease;
    color: #333;
}

.feature-item:hover .icon-bg {
    color: #fff;
}

.feature-number {
    font-size: 2.5rem;
    font-weight: 700;
    background: linear-gradient(45deg, #ff4d4d, #f9004d);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    opacity: 0.8;
}

.feature-content {
    padding: 25px;
    flex-grow: 1;
}

.feature-content h4 {
    font-weight: 700;
    font-size: 1.3rem;
    margin-bottom: 15px;
    color: #333;
}

.feature-content p {
    color: #666;
    font-size: 0.95rem;
    margin-bottom: 20px;
}

.feature-line {
    height: 3px;
    width: 40px;
    background: linear-gradient(45deg, #ff4d4d, #f9004d);
}

.btn-cta {
    background: linear-gradient(45deg, #ff4d4d, #f9004d);
    color: white;
    border: none;
    border-radius: 30px;
    padding: 12px 30px;
    font-weight: 600;
    letter-spacing: 0.5px;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    margin-top: 20px;
    z-index: 1;
}

.btn-cta:hover {
    color: white;
    box-shadow: 0 5px 20px rgba(249, 0, 77, 0.4);
    transform: translateY(-2px);
}

.btn-cta::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(45deg, #f9004d, #ff4d4d);
    z-index: -1;
    transition: transform 0.6s;
    transform: scaleX(0);
    transform-origin: right;
}

.btn-cta:hover::before {
    transform: scaleX(1);
    transform-origin: left;
}

@media (max-width: 992px) {
    .feature-item {
        flex-direction: column;
        text-align: center;
    }
    
    .feature-icon {
        border-right: none;
        border-bottom: 1px solid rgba(0,0,0,0.07);
        width: 100%;
    }
    
    .feature-line {
        margin: 0 auto;
    }
}
</style>
<?= $this->endSection() ?>
