<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row">
        <div class="col-lg-6">
            <div class="detail-image-container">
                <div class="availability-tag">Tersedia</div>
                <?php if(is_discount_day($car['id'])):
                    $discountPercentage = get_discount_percentage($car['id']);    
                ?>
                <div class="discount-badge">Diskon <?= number_format($discountPercentage, 0) ?>% Hari Ini!</div>
                <?php endif; ?>
                <img src="<?= base_url('uploads/cars/' . $car['image']) ?>" class="detail-image" alt="<?= $car['brand'] . ' ' . $car['model'] ?>">
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="car-info-container">
                <h1 class="car-title"><?= $car['brand'] . ' ' . $car['model'] ?></h1>
                <p class="car-subtitle"><?= $car['year'] ?> • License Plate: <?= $car['license_plate'] ?></p>
                
                <div class="features-grid">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-snowflake"></i>
                        </div>
                        <div class="feature-text">AC</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-bluetooth-b"></i>
                        </div>
                        <div class="feature-text">Bluetooth</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-video"></i>
                        </div>
                        <div class="feature-text">Kamera</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="feature-text">GPS</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-usb"></i>
                        </div>
                        <div class="feature-text">USB Port</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-music"></i>
                        </div>
                        <div class="feature-text">Audio</div>
                    </div>
                </div>
                
                <div class="price-container">
                    <div class="price-row">
                        <div class="price-category">
                            <div class="price-label">12 jam / dalam kota</div>
                        </div>
                        <div class="price-amount">
                            <?php if(is_discount_day($car['id'])): ?>
                                <span class="original-price">Rp <?= number_format($car['daily_rate'] * 0.5, 0, ',', '.') ?> - Rp <?= number_format($car['daily_rate'] * 0.75, 0, ',', '.') ?></span>
                                <span class="discounted-price">Rp <?= number_format(get_discounted_price($car, 0.5), 0, ',', '.') ?> - Rp <?= number_format(get_discounted_price($car, 0.75), 0, ',', '.') ?></span>
                            <?php else: ?>
                                Rp <?= number_format($car['daily_rate'] * 0.5, 0, ',', '.') ?> - Rp 
                                <?= number_format($car['daily_rate'] * 0.75, 0, ',', '.') ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="price-row">
                        <div class="price-category">
                            <div class="price-label">Harian + Supir</div>
                        </div>
                        <div class="price-amount">
                            <?php if(is_discount_day($car['id'])): ?>
                                <span class="original-price">Rp <?= number_format($car['daily_rate'] * 0.75, 0, ',', '.') ?> - Rp <?= number_format($car['daily_rate'], 0, ',', '.') ?></span>
                                <span class="discounted-price">Rp <?= number_format(get_discounted_price($car, 0.75), 0, ',', '.') ?> - Rp <?= number_format(get_discounted_price($car, 1), 0, ',', '.') ?></span>
                            <?php else: ?>
                                Rp <?= number_format($car['daily_rate'] * 0.75, 0, ',', '.') ?> - Rp 
                                <?= number_format($car['daily_rate'], 0, ',', '.') ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="price-row monthly">
                        <div class="price-category">
                            <div class="price-label">Monthly</div>
                        </div>
                        <div class="price-amount monthly-price">
                            <?php if(is_discount_day($car['id'])): ?>
                                <span class="original-price">Rp <?= number_format($car['daily_rate'] * 30 * 0.8, 0, ',', '.') ?></span>
                                <span>Rp <?= number_format(get_discounted_price($car, 30 * 0.8), 0, ',', '.') ?></span>
                            <?php else: ?>
                                Rp <?= number_format($car['daily_rate'] * 30 * 0.8, 0, ',', '.') ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <?php if(is_discount_day($car['id'])): 
                        $discountPercentage = get_discount_percentage($car['id']);
                    ?>
                    <div class="discount-info">
                        <i class="fas fa-tags"></i> Diskon <?= number_format($discountPercentage, 0) ?>% berlaku untuk hari ini (<?= date('l') ?>)!
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="action-buttons">
                    <?php if (session()->get('isLoggedIn')): ?>
                    <a href="<?= site_url('rentals/create/' . $car['id']) ?>" class="btn-rent">
                        <i class="fas fa-calendar-check"></i> Sewa Sekarang
                    </a>
                    <?php else: ?>
                    <a href="<?= site_url('login?redirect=cars/' . $car['id']) ?>" class="btn-rent">
                        <i class="fas fa-sign-in-alt"></i> Login untuk Menyewa
                    </a>
                    <?php endif; ?>
                    
                    <a href="https://wa.me/083896297994?text=Saya%20tertarik%20untuk%20menyewa%20<?= urlencode($car['brand'] . ' ' . $car['model']) ?>" class="btn-whatsapp">
                        <i class="fab fa-whatsapp"></i> Pesan via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="car-details-tabs mt-5">
        <ul class="nav nav-tabs" id="carDetailTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Deskripsi</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications" type="button" role="tab" aria-controls="specifications" aria-selected="false">Spesifikasi</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Ulasan <span class="badge bg-primary ms-1"><?= $reviewCount ?></span></button>
            </li>
        </ul>
        <div class="tab-content p-4 bg-white shadow-sm rounded-bottom" id="carDetailTabsContent">
            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                <h5>Deskripsi Mobil</h5>
                        <p><?= $car['description'] ?></p>
            </div>
            <div class="tab-pane fade" id="specifications" role="tabpanel" aria-labelledby="specifications-tab">
                <h5>Spesifikasi Lengkap</h5>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="specs-list">
                            <li><strong>Merek:</strong> <?= $car['brand'] ?></li>
                            <li><strong>Model:</strong> <?= $car['model'] ?></li>
                            <li><strong>Tahun:</strong> <?= $car['year'] ?></li>
                            <li><strong>Transmisi:</strong> Automatic</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="specs-list">
                            <li><strong>Bahan Bakar:</strong> Bensin</li>
                            <li><strong>Kapasitas:</strong> 5 Penumpang</li>
                            <li><strong>Warna:</strong> <?= $car['color'] ?? 'Hitam' ?></li>
                            <li><strong>Nomor Polisi:</strong> <?= $car['license_plate'] ?></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                <div class="reviews-container">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5>Ulasan Pengguna</h5>
                        <div class="rating-summary">
                            <div class="d-flex align-items-center">
                                <div class="overall-rating me-2"><?= $averageRating ?></div>
                                <div class="stars">
                                    <?php for($i=1; $i <= 5; $i++): ?>
                                        <?php if($i <= round($averageRating)): ?>
                                            <i class="fas fa-star text-warning"></i>
                                        <?php elseif($i - 0.5 <= $averageRating): ?>
                                            <i class="fas fa-star-half-alt text-warning"></i>
                                        <?php else: ?>
                                            <i class="far fa-star text-warning"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                                <div class="total-reviews ms-2">(<?= $reviewCount ?> ulasan)</div>
                            </div>
                        </div>
                    </div>
                    
                    <?php if(empty($reviews)): ?>
                        <div class="alert alert-light text-center py-4">
                            <i class="far fa-comment-alt fs-3 mb-3 text-muted"></i>
                            <p class="mb-0">Belum ada ulasan untuk mobil ini</p>
                        </div>
                    <?php else: ?>
                        <div class="review-list">
                            <?php foreach($reviews as $review): ?>
                                <div class="review-card mb-4">
                                    <div class="review-header d-flex justify-content-between">
                                        <div class="reviewer-info d-flex align-items-center">
                                            <div class="reviewer-avatar me-3">
                                                <div class="avatar-circle">
                                                    <?= substr($review['username'], 0, 1) ?>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="reviewer-name mb-0"><?= $review['username'] ?></h6>
                                                <div class="review-date text-muted small">
                                                    <?= date('d M Y', strtotime($review['created_at'])) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="review-rating">
                                            <?php for($i=1; $i <= 5; $i++): ?>
                                                <?php if($i <= $review['rating']): ?>
                                                    <i class="fas fa-star text-warning"></i>
                                                <?php else: ?>
                                                    <i class="far fa-star text-warning"></i>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    <div class="review-content mt-3">
                                        <p class="mb-0"><?= nl2br($review['comment']) ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
                    
<style>
    .detail-image-container {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        background-color: white;
        height: 380px;
    }
    
    .detail-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center center;
        display: block;
        transition: transform 0.5s ease;
    }
    
    .detail-image-container:hover .detail-image {
        transform: scale(1.03);
    }
    
    .availability-tag {
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
    
    .car-info-container {
        background-color: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        height: 100%;
    }
    
    .car-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text-color);
        margin-bottom: 5px;
    }
    
    .car-subtitle {
        color: var(--gray-color);
        margin-bottom: 20px;
        font-size: 0.95rem;
    }
    
    .features-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 25px;
    }
    
    .feature-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    
    .feature-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: rgba(67, 97, 238, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 8px;
        transition: all 0.3s ease;
    }
    
    .feature-icon i {
        color: var(--primary-color);
        font-size: 1.2rem;
    }
    
    .feature-item:hover .feature-icon {
        background: var(--primary-color);
        transform: translateY(-3px);
    }
    
    .feature-item:hover .feature-icon i {
        color: white;
    }
    
    .feature-text {
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--text-color);
    }
    
    .price-container {
        background-color: #f8f9fa;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 25px;
    }
    
    .price-row {
        display: grid;
        grid-template-columns: 0.9fr 1.1fr;
        padding: 8px 0;
        border-bottom: 1px dashed rgba(0, 0, 0, 0.06);
        align-items: center;
    }
    
    .price-row.monthly {
        border-bottom: none;
    }
    
    .price-category {
        color: var(--gray-color);
    }
    
    .price-label {
        font-size: 0.85rem;
    }
    
    .price-amount {
        font-weight: 600;
        font-size: 0.9rem;
        text-align: right;
        white-space: nowrap;
        color: #333;
    }
    
    .price-amount.monthly-price {
        color: #4361ee;
        font-weight: 700;
        font-size: 1rem;
    }
    
    .action-buttons {
        display: flex;
        gap: 12px;
    }
    
    .btn-rent {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
        color: white;
        padding: 12px 15px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    
    .btn-rent i {
        margin-right: 8px;
    }
    
    .btn-rent:hover {
        background: linear-gradient(135deg, var(--gradient-end) 0%, var(--gradient-start) 100%);
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(67, 97, 238, 0.25);
        color: white;
    }
    
    .btn-whatsapp {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
        color: white;
        padding: 12px 15px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-whatsapp i {
        margin-right: 8px;
    }
    
    .btn-whatsapp:hover {
        background: linear-gradient(135deg, #128C7E 0%, #25D366 100%);
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(37, 211, 102, 0.25);
        color: white;
    }
    
    .car-details-tabs {
        background-color: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .nav-tabs {
        border-bottom: none;
        padding: 0 15px;
        background-color: #f8f9fa;
    }
    
    .nav-tabs .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
        border-radius: 0;
        padding: 15px 20px;
        font-weight: 600;
        color: var(--gray-color);
        transition: all 0.3s ease;
    }
    
    .nav-tabs .nav-link.active {
        color: var(--primary-color);
        background-color: transparent;
        border-bottom: 3px solid var(--primary-color);
    }
    
    .nav-tabs .nav-link:hover:not(.active) {
        border-bottom: 3px solid rgba(67, 97, 238, 0.3);
        color: var(--text-color);
    }
    
    .specs-list {
        list-style: none;
        padding: 0;
    }
    
    .specs-list li {
        padding: 8px 0;
        border-bottom: 1px dashed rgba(0, 0, 0, 0.06);
    }
    
    .specs-list li:last-child {
        border-bottom: none;
    }
    
    .specs-list li strong {
        color: var(--text-color);
        font-weight: 600;
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
    
    .discounted-price {
        color: #ee5253;
        font-weight: 700;
    }
    
    .discount-info {
        margin-top: 15px;
        padding: 10px;
        background-color: #ffecec;
        border-radius: 8px;
        color: #ee5253;
        font-weight: 600;
        text-align: center;
        font-size: 0.9rem;
    }
    
    .discount-info i {
        margin-right: 5px;
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
    
    /* Reviews Styling */
    .overall-rating {
        font-size: 1.5rem;
        font-weight: 700;
        color: #333;
    }
    
    .total-reviews {
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    .review-card {
        padding: 16px;
        border-radius: 10px;
        background-color: #f8f9fa;
        border-left: 3px solid #4361ee;
    }
    
    .avatar-circle {
        width: 40px;
        height: 40px;
        background-color: #4361ee;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }
    
    .reviewer-name {
        font-weight: 600;
        color: #333;
    }
    
    .review-content {
        color: #495057;
        line-height: 1.6;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pickupDateInput = document.getElementById('pickup_date');
    const returnDateInput = document.getElementById('return_date');
    const rentalSummary = document.getElementById('rental_summary');
    const totalDaysElement = document.getElementById('total_days');
    const totalAmountElement = document.getElementById('total_amount');
    const dailyRate = <?= $car['daily_rate'] ?>;
    
    if (pickupDateInput && returnDateInput) {
    function updateRentalSummary() {
        const pickupDate = new Date(pickupDateInput.value);
        const returnDate = new Date(returnDateInput.value);
        
        if (pickupDate && returnDate && returnDate > pickupDate) {
            const diffTime = Math.abs(returnDate - pickupDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            totalDaysElement.textContent = diffDays;
            totalAmountElement.textContent = '$' + (diffDays * dailyRate).toFixed(2);
            
            rentalSummary.classList.remove('d-none');
        } else {
            rentalSummary.classList.add('d-none');
        }
    }
    
    pickupDateInput.addEventListener('change', updateRentalSummary);
    returnDateInput.addEventListener('change', updateRentalSummary);
    }
});
</script>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    <?php if(session()->getFlashdata('active_tab') == 'reviews'): ?>
    // Activate reviews tab
    document.querySelector('#reviews-tab').click();
    <?php endif; ?>
});
</script>
<?= $this->endSection() ?>

