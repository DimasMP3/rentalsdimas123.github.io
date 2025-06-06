<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="cars-header mb-4">
        <h1 class="cars-title"><?= isset($current_category) ? 'Mobil ' . $current_category['name'] : 'Mobil Tersedia' ?></h1>
        <p class="cars-subtitle">Pilih dan sewa mobil yang sesuai dengan kebutuhan Anda</p>
    </div>
    
    <div class="row">
        <div class="col-md-3">
            <div class="filter-card mb-4">
                <div class="filter-header">
                    <h5 class="mb-0">Filter Pencarian</h5>
                </div>
                <div class="filter-body">
                    <form action="<?= site_url('cars') ?>" method="get">
                        <div class="mb-3">
                            <label for="category" class="filter-label">Kategori</label>
                            <select name="category" id="category" class="form-select">
                                <option value="">Semua Kategori</option>
                                <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>" <?= isset($_GET['category']) && $_GET['category'] == $category['id'] ? 'selected' : '' ?>>
                                    <?= $category['name'] ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="min_price" class="filter-label">Harga Minimum</label>
                            <input type="number" name="min_price" id="min_price" class="form-control" value="<?= isset($_GET['min_price']) ? $_GET['min_price'] : '' ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="max_price" class="filter-label">Harga Maksimum</label>
                            <input type="number" name="max_price" id="max_price" class="form-control" value="<?= isset($_GET['max_price']) ? $_GET['max_price'] : '' ?>">
                        </div>
                        
                        <button type="submit" class="filter-button">Terapkan Filter</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <?php if (empty($cars)): ?>
            <div class="alert alert-info">Tidak ada mobil yang sesuai kriteria pencarian Anda.</div>
            <?php else: ?>
            <div class="cars-grid">
                <?php foreach ($cars as $car): ?>
                <div class="car-card-wrapper">
                    <div class="car-card">
                        <div class="availability-tag">Tersedia</div>
                        <?php if(is_discount_day($car['id'])):
                            $discountPercentage = get_discount_percentage($car['id']);    
                        ?>
                        <div class="discount-badge">Diskon <?= number_format($discountPercentage, 0) ?>% Hari Ini!</div>
                        <?php endif; ?>
                        <div class="car-image-container">
                            <img src="<?= base_url('uploads/cars/' . $car['image']) ?>" class="car-image" alt="<?= $car['brand'] . ' ' . $car['model'] ?>">
                        </div>
                        <div class="car-details">
                            <h3 class="car-name"><?= $car['brand'] . ' ' . $car['model'] ?></h3>
                            
                            <div class="price-section">
                                <div class="price-row">
                                    <div class="price-category">
                                        <div class="price-label">24 jam dalam/luar kota</div>
                                    </div>
                                    <div class="price-amount">
                                        <?php if(is_discount_day($car['id'])): ?>
                                            <span class="original-price">Rp <?= number_format($car['daily_rate'] * 0.5, 0, ',', '.') ?></span>
                                            <span class="discounted-price">Rp <?= number_format(get_discounted_price($car, 0.5), 0, ',', '.') ?></span>
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
                                            <span class="original-price">Rp <?= number_format($car['daily_rate'], 0, ',', '.') ?></span>
                                            <span class="discounted-price">Rp <?= number_format(get_discounted_price($car, 1), 0, ',', '.') ?></span>
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
                            </div>
                            
                            <div class="car-actions">
                                <a href="<?= site_url('cars/' . $car['id']) ?>" class="detail-button">
                                    <i class="fas fa-info-circle"></i> Pesan
                                </a>
                                <a href="https://wa.me/083896297994?text=Saya%20tertarik%20untuk%20menyewa%20<?= urlencode($car['brand'] . ' ' . $car['model']) ?>" class="book-button">
                                    <i class="fab fa-whatsapp"></i> Tanya
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    /* Base styles */
    .cars-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }
    
    .cars-title {
        font-weight: 700;
        color: var(--text-color);
        margin-bottom: 0.75rem;
    }
    
    .cars-subtitle {
        color: var(--gray-color);
        font-size: 1.1rem;
    }
    
    /* Filter card styling */
    .filter-card {
        background-color: white;
        border-radius: 1rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.04);
        overflow: hidden;
        transition: all 0.3s ease;
        position: sticky;
        top: 5rem;
    }
    
    .filter-header {
        background-color: var(--light-gray);
        padding: 1rem 1.25rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .filter-body {
        padding: 1.25rem;
    }
    
    .filter-label {
        font-weight: 600;
        color: var(--text-color);
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        display: block;
    }
    
    .filter-button {
        background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
        color: white;
        border: none;
        padding: 0.75rem 0;
        border-radius: 0.5rem;
        font-weight: 600;
        width: 100%;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .filter-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
    }
    
    /* Car grid and card styling */
    .cars-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    
    .car-card {
        background-color: white;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.04);
        transition: all 0.4s ease;
        height: 100%;
        position: relative;
        display: flex;
        flex-direction: column;
    }
    
    .car-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
    }
    
    .availability-tag {
        position: absolute;
        top: 1rem;
        left: 1rem;
        background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 2rem;
        font-size: 0.8rem;
        font-weight: 600;
        z-index: 2;
        box-shadow: 0 3px 10px rgba(34, 197, 94, 0.25);
    }
    
    .discount-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5253 100%);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 2rem;
        font-size: 0.8rem;
        font-weight: 600;
        z-index: 2;
        box-shadow: 0 3px 10px rgba(238, 82, 83, 0.25);
        animation: pulse 1.5s infinite;
    }
    
    .car-image-container {
        height: 220px;
        overflow: hidden;
        position: relative;
    }
    
    .car-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        transition: transform 0.6s ease;
    }
    
    .car-card:hover .car-image {
        transform: scale(1.08);
    }
    
    .car-details {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    
    .car-name {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--text-color);
        text-align: center;
    }
    
    /* Price section styling */
    .price-section {
        margin-bottom: 1.25rem;
        flex-grow: 1;
        border-radius: 0.75rem;
        background-color: rgba(0, 0, 0, 0.01);
        padding: 0.75rem;
    }
    
    .price-row {
        display: grid;
        grid-template-columns: 0.9fr 1.1fr;
        padding: 0.6rem 0;
        border-bottom: 1px dashed rgba(0, 0, 0, 0.06);
        align-items: center;
    }
    
    .price-row.monthly {
        border-bottom: none;
        margin-top: 0.25rem;
        padding-top: 0.75rem;
        border-top: 1px solid rgba(0, 0, 0, 0.06);
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
        color: var(--gradient-start);
        font-weight: 700;
        font-size: 1rem;
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
    
    /* Button styling */
    .car-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
    }
    
    .detail-button, .book-button {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 0;
        border-radius: 0.5rem;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }
    
    .detail-button {
        background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
        color: white;
    }
    
    .book-button {
        background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
        color: white;
    }
    
    .detail-button i, .book-button i {
        margin-right: 0.5rem;
    }
    
    .detail-button:hover, .book-button:hover {
        transform: translateY(-2px);
        color: white;
    }
    
    .detail-button:hover {
        box-shadow: 0 5px 15px rgba(67, 97, 238, 0.25);
    }
    
    .book-button:hover {
        box-shadow: 0 5px 15px rgba(37, 211, 102, 0.25);
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    /* Responsive styles */
    @media (max-width: 1200px) {
        .cars-grid {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        }
    }
    
    @media (max-width: 991px) {
        .cars-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }
    }
    
    @media (max-width: 767px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .cars-grid {
            grid-template-columns: repeat(auto-fill, minmax(100%, 1fr));
        }
        
        .filter-card {
            margin-bottom: 1.5rem;
            position: relative;
            top: 0;
        }
        
        .car-image-container {
            height: 200px;
        }
    }
    
    @media (max-width: 480px) {
        .cars-title {
            font-size: 1.5rem;
        }
        
        .cars-subtitle {
            font-size: 1rem;
        }
        
        .price-row {
            grid-template-columns: 1fr;
            gap: 0.25rem;
        }
        
        .price-amount {
            text-align: left;
        }
        
        .car-actions {
            grid-template-columns: 1fr;
        }
    }
</style>
<?= $this->endSection() ?>
