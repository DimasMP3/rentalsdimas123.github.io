<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold"><i class="fas fa-list-alt me-2 text-primary"></i>Pesanan Saya</h1>
        <a href="<?= site_url('cars') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Sewa Mobil Baru
        </a>
    </div>
    
    <?php if (session()->has('success')): ?>
    <div class="alert alert-success shadow-sm border-0">
        <i class="fas fa-check-circle me-2"></i><?= session('success') ?>
    </div>
    <?php endif; ?>
    
    <?php if (session()->has('error')): ?>
    <div class="alert alert-danger shadow-sm border-0">
        <i class="fas fa-exclamation-circle me-2"></i><?= session('error') ?>
    </div>
    <?php endif; ?>
    
    <?php if (empty($orders)): ?>
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body text-center py-5">
            <img src="<?= base_url('assets/images/empty-state.svg') ?>" alt="No Orders" class="img-fluid mb-3" style="max-height: 200px; opacity: 0.7;" onerror="this.src='https://cdn-icons-png.flaticon.com/512/5445/5445197.png'; this.style.height='100px';">
            <h4 class="fw-bold text-muted">Belum Ada Pesanan</h4>
            <p class="text-muted mb-4">Anda belum memiliki pesanan sewa mobil apapun.</p>
            <a href="<?= site_url('cars') ?>" class="btn btn-primary px-4 py-2">
                <i class="fas fa-car me-2"></i>Lihat Daftar Mobil
            </a>
        </div>
    </div>
    <?php else: ?>
    <div class="orders-filter mb-4">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link active" href="#" data-filter="all">Semua</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-filter="pending">Menunggu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-filter="approved">Disetujui</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-filter="completed">Selesai</a>
            </li>
        </ul>
    </div>

    <div class="row g-4">
        <?php foreach ($orders as $order): ?>
        <div class="col-lg-6 order-item" data-status="<?= $order['status'] ?>">
            <div class="card h-100 border-0 shadow-sm rounded-3 position-relative overflow-hidden">
                <div class="card-status-indicator bg-<?= $order['status'] == 'pending' ? 'warning' : ($order['status'] == 'approved' ? 'success' : ($order['status'] == 'completed' ? 'info' : 'danger')) ?>"></div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-4 pe-0">
                            <div class="order-image-container">
                                <?php if(!empty($order['image'])): ?>
                                <img src="<?= base_url('uploads/cars/' . $order['image']) ?>" alt="<?= $order['brand'] . ' ' . $order['model'] ?>" class="img-car">
                                <?php else: ?>
                                <div class="no-image">
                                    <i class="fas fa-car"></i>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="d-flex justify-content-between mb-2">
                                <h5 class="card-title fw-bold mb-0"><?= $order['brand'] . ' ' . $order['model'] ?></h5>
                                <span class="badge bg-<?= $order['status'] == 'pending' ? 'warning' : ($order['status'] == 'approved' ? 'success' : ($order['status'] == 'completed' ? 'info' : 'danger')) ?>">
                                    <?= ucfirst($order['status']) ?>
                                </span>
                            </div>
                            
                            <div class="order-period d-flex align-items-center my-3">
                                <div class="date-badge start">
                                    <span class="day"><?= date('d', strtotime($order['start_date'])) ?></span>
                                    <span class="month"><?= date('M', strtotime($order['start_date'])) ?></span>
                                </div>
                                <div class="duration-line">
                                    <?php
                                    $start = new DateTime($order['start_date']);
                                    $end = new DateTime($order['end_date']);
                                    $days = $end->diff($start)->days + 1;
                                    ?>
                                    <span class="days"><?= $days ?> hari</span>
                                </div>
                                <div class="date-badge end">
                                    <span class="day"><?= date('d', strtotime($order['end_date'])) ?></span>
                                    <span class="month"><?= date('M', strtotime($order['end_date'])) ?></span>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <span class="d-block text-muted small mb-1">Total Harga</span>
                                    <span class="fs-5 fw-bold text-primary">Rp <?= number_format($order['total_price'], 0, ',', '.') ?></span>
                                </div>
                                
                                <div class="d-flex align-items-center">
                                    <span class="payment-status me-3 <?= $order['payment_status'] == 'paid' ? 'text-success' : 'text-warning' ?>">
                                        <i class="fas <?= $order['payment_status'] == 'paid' ? 'fa-check-circle' : 'fa-clock' ?>"></i>
                                        <?= $order['payment_status'] == 'paid' ? 'Lunas' : 'Menunggu' ?>
                                    </span>
                                    <a href="<?= site_url('rentals/' . $order['id']) ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye me-1"></i> Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<style>
/* Card status indicator */
.card-status-indicator {
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
}

/* Order image */
.order-image-container {
    height: 150px;
    overflow: hidden;
    border-radius: 8px;
    position: relative;
    box-shadow: 0 0 5px rgba(0,0,0,0.1);
}

.order-image-container .img-car {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.order-image-container:hover .img-car {
    transform: scale(1.05);
}

.order-image-container .no-image {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    color: #adb5bd;
    font-size: 2rem;
}

/* Order period visualization */
.order-period {
    position: relative;
    margin: 15px 0;
}

.date-badge {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 5px;
    background: #f8f9fa;
    border-radius: 6px;
    min-width: 45px;
    text-align: center;
    z-index: 2;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.date-badge.start {
    border-left: 3px solid #0d6efd;
}

.date-badge.end {
    border-right: 3px solid #0d6efd;
}

.date-badge .day {
    font-weight: bold;
    font-size: 14px;
}

.date-badge .month {
    font-size: 11px;
    text-transform: uppercase;
    color: #6c757d;
}

.duration-line {
    flex: 1;
    height: 2px;
    background: #e9ecef;
    margin: 0 5px;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.duration-line:before,
.duration-line:after {
    content: '';
    position: absolute;
    width: 6px;
    height: 6px;
    background: #0d6efd;
    border-radius: 50%;
}

.duration-line:before {
    left: 0;
}

.duration-line:after {
    right: 0;
}

.duration-line .days {
    background: #e9ecef;
    padding: 3px 8px;
    border-radius: 20px;
    font-size: 11px;
    color: #495057;
    font-weight: 600;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

/* Payment status */
.payment-status {
    font-size: 0.85rem;
    display: flex;
    align-items: center;
}

.payment-status i {
    margin-right: 5px;
}

/* Pills navigation */
.orders-filter .nav-pills {
    border-bottom: 1px solid #dee2e6;
    padding-bottom: 10px;
}

.orders-filter .nav-pills .nav-link {
    border-radius: 20px;
    padding: 5px 15px;
    color: #6c757d;
    transition: all 0.3s ease;
}

.orders-filter .nav-pills .nav-link:hover {
    background-color: #f8f9fa;
}

.orders-filter .nav-pills .nav-link.active {
    background-color: #0d6efd;
    color: white;
    box-shadow: 0 2px 5px rgba(13, 110, 253, 0.3);
}

/* Card hover effect */
.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter orders
    document.querySelectorAll('.orders-filter .nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Set active class
            document.querySelectorAll('.orders-filter .nav-link').forEach(item => {
                item.classList.remove('active');
            });
            this.classList.add('active');
            
            const filter = this.getAttribute('data-filter');
            
            // Filter items
            document.querySelectorAll('.order-item').forEach(item => {
                if (filter === 'all' || item.getAttribute('data-status') === filter) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});
</script>
<?= $this->endSection() ?>
