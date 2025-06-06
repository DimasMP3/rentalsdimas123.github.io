<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 fw-bold"><i class="fas fa-file-invoice me-2"></i>Detail Pesanan</h1>
                <a href="<?= site_url('rentals') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
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
            
            <div class="row g-4">
                <!-- Order Status Overview -->
                <div class="col-12">
                    <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <div class="col-md-6 p-4 bg-primary bg-opacity-10 border-end">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="status-icon me-3 <?= $order['status'] == 'pending' ? 'bg-warning' : ($order['status'] == 'approved' ? 'bg-success' : ($order['status'] == 'completed' ? 'bg-info' : 'bg-danger')) ?>">
                                            <i class="fas <?= $order['status'] == 'pending' ? 'fa-clock' : ($order['status'] == 'approved' ? 'fa-check' : ($order['status'] == 'completed' ? 'fa-flag-checkered' : 'fa-times')) ?>"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-muted">Status Pesanan</h6>
                                            <span class="fs-5 fw-bold text-<?= $order['status'] == 'pending' ? 'warning' : ($order['status'] == 'approved' ? 'success' : ($order['status'] == 'completed' ? 'info' : 'danger')) ?>">
                                                <?= ucfirst($order['status']) ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="status-icon me-3 <?= $order['payment_status'] == 'paid' ? 'bg-success' : ($order['payment_status'] == 'pending' ? 'bg-warning' : 'bg-danger') ?>">
                                            <i class="fas <?= $order['payment_status'] == 'paid' ? 'fa-check-circle' : ($order['payment_status'] == 'pending' ? 'fa-clock' : 'fa-times-circle') ?>"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-muted">Status Pembayaran</h6>
                                            <span class="fs-5 fw-bold text-<?= $order['payment_status'] == 'paid' ? 'success' : ($order['payment_status'] == 'pending' ? 'warning' : 'danger') ?>">
                                                <?= $order['payment_status'] == 'paid' ? 'Lunas' : ($order['payment_status'] == 'pending' ? 'Menunggu Pembayaran' : 'Gagal') ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 p-4 bg-white">
                                    <p class="mb-1 small text-uppercase text-muted">Total Harga</p>
                                    <h3 class="fw-bold text-primary mb-3">Rp <?= number_format($order['total_price'], 0, ',', '.') ?></h3>
                                    
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">ID Pesanan:</span>
                                        <span class="fw-bold">#<?= $order['id'] ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Metode Pembayaran:</span>
                                        <span class="fw-bold"><?= ucfirst(str_replace('_', ' ', $order['payment_method'])) ?></span>
                                    </div>
                                    
                                    <?php if (!empty($order['notes'])): ?>
                                    <div class="mt-3 p-2 bg-light rounded">
                                        <p class="small text-muted mb-1">Catatan:</p>
                                        <p class="mb-0"><?= $order['notes'] ?></p>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Rental Details -->
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-3 h-100">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold"><i class="fas fa-calendar-alt me-2 text-primary"></i>Detail Penyewaan</h5>
                        </div>
                        <div class="card-body">
                            <div class="rental-timeline">
                                <div class="rental-timeline-item">
                                    <div class="rental-timeline-marker"></div>
                                    <div class="rental-timeline-content">
                                        <h6 class="text-primary mb-1">Tanggal Mulai</h6>
                                        <p class="fs-5 fw-bold mb-1"><?= date('d M Y', strtotime($order['start_date'])) ?></p>
                                        <p class="text-muted small mb-0"><?= date('l', strtotime($order['start_date'])) ?></p>
                                    </div>
                                </div>
                                <div class="rental-timeline-item">
                                    <div class="rental-timeline-marker"></div>
                                    <div class="rental-timeline-content">
                                        <h6 class="text-primary mb-1">Tanggal Selesai</h6>
                                        <p class="fs-5 fw-bold mb-1"><?= date('d M Y', strtotime($order['end_date'])) ?></p>
                                        <p class="text-muted small mb-0"><?= date('l', strtotime($order['end_date'])) ?></p>
                                    </div>
                                </div>
                                <div class="rental-timeline-item">
                                    <div class="rental-timeline-marker"></div>
                                    <div class="rental-timeline-content">
                                        <h6 class="text-primary mb-1">Durasi</h6>
                                        <?php
                                        $start = new DateTime($order['start_date']);
                                        $end = new DateTime($order['end_date']);
                                        $days = $end->diff($start)->days + 1;
                                        ?>
                                        <p class="fs-5 fw-bold mb-0"><?= $days ?> hari</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Car Details -->
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-3 h-100">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold"><i class="fas fa-car me-2 text-primary"></i>Informasi Mobil</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <div class="col-md-5">
                                    <?php if(!empty($order['image'])): ?>
                                    <img src="<?= base_url('uploads/cars/' . $order['image']) ?>" class="img-fluid rounded-start h-100" style="object-fit: cover;" alt="<?= $order['brand'] . ' ' . $order['model'] ?>">
                                    <?php else: ?>
                                    <div class="bg-light text-center py-5 h-100">
                                        <i class="fas fa-car fa-4x text-secondary"></i>
                                        <p class="mt-2 text-muted">No image available</p>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-7 p-3">
                                    <h5 class="fw-bold mb-1"><?= $order['brand'] . ' ' . $order['model'] ?></h5>
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge bg-secondary me-2"><?= $order['year'] ?></span>
                                        <span class="badge bg-light text-dark border"><?= $order['license_plate'] ?></span>
                                    </div>
                                    <div class="mb-3">
                                        <span class="d-block text-muted small mb-1">Harga Sewa per Hari</span>
                                        <span class="fw-bold">Rp <?= number_format($order['daily_rate'], 0, ',', '.') ?></span>
                                    </div>
                                    <?php if (!empty($order['description'])): ?>
                                    <p class="small text-muted mb-0"><?= $order['description'] ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Payment Upload Section -->
                <?php if ($order['payment_status'] == 'pending'): ?>
                <div class="col-12">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold"><i class="fas fa-receipt me-2 text-primary"></i>Upload Bukti Pembayaran</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <form action="<?= site_url('rentals/upload-payment/' . $order['id']) ?>" method="post" enctype="multipart/form-data">
                                        <?= csrf_field() ?>
                                        <div class="mb-3">
                                            <label for="payment_proof" class="form-label">Bukti Pembayaran</label>
                                            <input type="file" name="payment_proof" id="payment_proof" class="form-control" accept="image/*" required>
                                            <div class="form-text">Upload bukti transfer bank, screenshot, atau konfirmasi pembayaran lainnya.</div>
                                        </div>
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-upload me-2"></i>Upload Bukti Pembayaran
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                
                                <div class="col-md-5">
                                    <?php if (isset($payment) && !empty($payment['payment_proof'])): ?>
                                    <div class="mb-3 text-center">
                                        <p class="fw-bold mb-2"><i class="fas fa-image me-1"></i> Bukti Pembayaran Saat Ini</p>
                                        <div class="payment-proof-container">
                                            <img src="<?= base_url('uploads/payments/' . $payment['payment_proof']) ?>" class="img-fluid rounded" alt="Bukti Pembayaran">
                                            <div class="payment-proof-overlay">
                                                <span class="badge rounded-pill bg-warning">Menunggu Verifikasi</span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($order['payment_method'] == 'bank_transfer'): ?>
                                    <div class="bank-info mt-4">
                                        <h6 class="fw-bold mb-3">Informasi Rekening Bank:</h6>
                                        <div class="bank-account-card mb-2">
                                            <div class="bank-logo">BCA</div>
                                            <div class="bank-details">
                                                <h6 class="mb-1">Bank BCA</h6>
                                                <p class="mb-1">No. Rekening: <span class="fw-bold">1234567890</span></p>
                                                <p class="mb-0">Atas Nama: PT Rental Mobil Indonesia</p>
                                            </div>
                                        </div>
                                        <div class="bank-account-card">
                                            <div class="bank-logo">MDR</div>
                                            <div class="bank-details">
                                                <h6 class="mb-1">Bank Mandiri</h6>
                                                <p class="mb-1">No. Rekening: <span class="fw-bold">0987654321</span></p>
                                                <p class="mb-0">Atas Nama: PT Rental Mobil Indonesia</p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Document Section - Display uploaded files when order is approved -->
                <?php if ($order['status'] == 'approved' && $order['payment_status'] == 'paid'): ?>
                <!-- Add attachment display section here -->
                <?php endif; ?>
                
                <!-- Review Section - Only show when order status is completed -->
                <?php if ($order['status'] == 'completed'): ?>
                <div class="col-12">
                    <div class="card shadow-sm border-0 rounded-3 mt-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold"><i class="fas fa-star me-2 text-warning"></i>Ulasan Sewa</h5>
                        </div>
                        <div class="card-body">
                            <?php if (session()->has('errors')): ?>
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        <?php foreach (session('errors') as $error): ?>
                                            <li><?= $error ?></li>
                                        <?php endforeach ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (isset($hasReviewed) && $hasReviewed): ?>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>Anda telah memberikan ulasan untuk pesanan ini. Terima kasih atas feedback Anda!
                                </div>
                            <?php else: ?>
                                <form action="<?= site_url('rentals/submit-review/' . $order['id']) ?>" method="post">
                                    <?= csrf_field() ?>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Beri Rating</label>
                                        <div class="rating-stars">
                                            <div class="stars">
                                                <input type="radio" name="rating" id="star-5" value="5">
                                                <label for="star-5"><i class="fas fa-star"></i></label>
                                                
                                                <input type="radio" name="rating" id="star-4" value="4">
                                                <label for="star-4"><i class="fas fa-star"></i></label>
                                                
                                                <input type="radio" name="rating" id="star-3" value="3" checked>
                                                <label for="star-3"><i class="fas fa-star"></i></label>
                                                
                                                <input type="radio" name="rating" id="star-2" value="2">
                                                <label for="star-2"><i class="fas fa-star"></i></label>
                                                
                                                <input type="radio" name="rating" id="star-1" value="1">
                                                <label for="star-1"><i class="fas fa-star"></i></label>
                                            </div>
                                            <span class="rating-text ms-2">(Pilih bintang untuk memberi rating)</span>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="comment" class="form-label fw-bold">Komentar Anda</label>
                                        <textarea class="form-control" name="comment" id="comment" rows="4" required placeholder="Bagikan pengalaman Anda menggunakan mobil ini..."><?= old('comment') ?></textarea>
                                        <div class="form-text">Minimal 10 karakter. Tuliskan pengalaman Anda dengan jujur untuk membantu pengguna lain.</div>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane me-2"></i>Kirim Ulasan
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Display uploaded attachment - Hide when status is completed -->
                <?php if (!empty($order['attachment']) && $order['status'] !== 'completed'): ?>
                <div class="col-12 mt-4">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold"><i class="fas fa-file-alt me-2 text-primary"></i>Silahkan Unduh Gambar Ini Untuk Bukti Saat Pengambilan Mobil</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <?php $ext = pathinfo($order['attachment'], PATHINFO_EXTENSION); ?>
                                        <?php if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png'])): ?>
                                            <img src="<?= base_url('uploads/attachments/' . $order['attachment']) ?>" class="img-fluid rounded" alt="Lampiran">
                                        <?php else: ?>
                                            <i class="fas fa-file fa-3x text-secondary"></i>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <a href="<?= base_url('uploads/attachments/' . $order['attachment']) ?>" class="btn btn-primary" download>
                                        <i class="fas fa-download me-2"></i> Unduh Lampiran
                                    </a>
                                    <p class="mt-2">Nama File: <?= $order['attachment'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
/* Status icon styling */
.status-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

/* Rental timeline styling */
.rental-timeline {
    position: relative;
    padding-left: 30px;
}

.rental-timeline:before {
    content: '';
    position: absolute;
    left: 5px;
    top: 0;
    bottom: 0;
    width: 1px;
    background: #e9ecef;
}

.rental-timeline-item {
    position: relative;
    padding-bottom: 25px;
}

.rental-timeline-item:last-child {
    padding-bottom: 0;
}

.rental-timeline-marker {
    position: absolute;
    left: -30px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #0d6efd;
    top: 5px;
}

.rental-timeline-marker:before {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 1px solid #0d6efd;
    left: -4px;
    top: -4px;
}

/* Bank account card styling */
.bank-account-card {
    display: flex;
    background: #f8f9fa;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.bank-logo {
    width: 60px;
    background: #0d6efd;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 18px;
}

.bank-details {
    padding: 12px;
    flex-grow: 1;
}

/* Payment proof container */
.payment-proof-container {
    position: relative;
    max-height: 200px;
    overflow: hidden;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.payment-proof-container img {
    width: 100%;
    object-fit: cover;
}

.payment-proof-overlay {
    position: absolute;
    top: 10px;
    right: 10px;
}

/* Rating stars styling */
.rating-stars {
    display: flex;
    align-items: center;
}

.stars {
    display: inline-flex;
    flex-direction: row-reverse;
    position: relative;
}

.stars input {
    display: none;
}

.stars label {
    font-size: 24px;
    color: #ddd;
    cursor: pointer;
    margin-right: 5px;
    transition: color 0.2s;
}

.stars label:hover,
.stars label:hover ~ label,
.stars input:checked ~ label {
    color: #ffca08;
}

.rating-text {
    font-size: 14px;
    color: #6c757d;
}
</style>
<?= $this->endSection() ?>
