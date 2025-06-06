<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-star text-warning mr-2"></i> Detail Ulasan #<?= $review['id'] ?></h1>
        <a href="<?= site_url('admin/reviews') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>
    
    <?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle mr-1"></i> <?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>
    
    <?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle mr-1"></i> <?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Ulasan</h6>
                    <div class="btn-group">
                        <?php if(!$review['is_approved']): ?>
                        <a href="<?= site_url('admin/reviews/approve/' . $review['id']) ?>" class="btn btn-sm btn-success">
                            <i class="fas fa-check"></i> Approve
                        </a>
                        <?php else: ?>
                        <a href="<?= site_url('admin/reviews/reject/' . $review['id']) ?>" class="btn btn-sm btn-warning">
                            <i class="fas fa-ban"></i> Reject
                        </a>
                        <?php endif; ?>
                        <a href="<?= site_url('admin/reviews/delete/' . $review['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?')">
                            <i class="fas fa-trash"></i> Delete
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="review-content p-3">
                        <div class="review-rating mb-3">
                            <div class="d-flex align-items-center">
                                <div class="text-warning mr-2">
                                    <?php for($i=1; $i <= 5; $i++): ?>
                                        <?php if($i <= $review['rating']): ?>
                                            <i class="fas fa-star"></i>
                                        <?php else: ?>
                                            <i class="far fa-star"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                                <h5 class="mb-0"><?= $review['rating'] ?>/5</h5>
                            </div>
                        </div>
                        
                        <div class="review-text p-3 bg-light rounded">
                            <p class="mb-0"><?= nl2br($review['comment']) ?></p>
                        </div>
                        
                        <div class="review-meta mt-3">
                            <div class="d-flex justify-content-between">
                                <span><i class="far fa-calendar mr-1"></i> <?= date('d M Y H:i', strtotime($review['created_at'])) ?></span>
                                <span class="badge <?= $review['is_approved'] ? 'badge-success' : 'badge-warning' ?>">
                                    <?= $review['is_approved'] ? 'Disetujui' : 'Menunggu Persetujuan' ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Pengguna</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar mr-3">
                            <div class="avatar-initial bg-primary rounded-circle">
                                <?= substr($review['username'], 0, 1) ?>
                            </div>
                        </div>
                        <div>
                            <h6 class="mb-0"><?= $review['username'] ?></h6>
                            <small class="text-muted"><?= $review['email'] ?></small>
                        </div>
                    </div>
                    
                    <a href="<?= site_url('admin/users/edit/' . $review['user_id']) ?>" class="btn btn-sm btn-outline-primary btn-block">
                        <i class="fas fa-user-edit mr-1"></i> Lihat Profil Pengguna
                    </a>
                </div>
            </div>
            
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Mobil</h6>
                </div>
                <div class="card-body">
                    <?php if(!empty($review['image'])): ?>
                    <img src="<?= base_url('uploads/cars/' . $review['image']) ?>" class="img-fluid mb-3 rounded" alt="<?= $review['brand'] . ' ' . $review['model'] ?>">
                    <?php endif; ?>
                    
                    <h6 class="font-weight-bold"><?= $review['brand'] . ' ' . $review['model'] ?></h6>
                    
                    <hr>
                    
                    <h6 class="font-weight-bold">Data Sewa</h6>
                    <div class="mb-2">
                        <span class="text-muted">ID Sewa:</span> #<?= $review['rental_id'] ?>
                    </div>
                    <div class="mb-2">
                        <span class="text-muted">Tanggal Sewa:</span><br>
                        <?= date('d M Y', strtotime($review['start_date'])) ?> - <?= date('d M Y', strtotime($review['end_date'])) ?>
                    </div>
                    
                    <div class="mt-3">
                        <a href="<?= site_url('admin/orders/view/' . $review['rental_id']) ?>" class="btn btn-sm btn-outline-info btn-block">
                            <i class="fas fa-file-invoice mr-1"></i> Lihat Detail Sewa
                        </a>
                        <a href="<?= site_url('admin/cars/edit/' . $review['car_id']) ?>" class="btn btn-sm btn-outline-secondary btn-block mt-2">
                            <i class="fas fa-car mr-1"></i> Lihat Detail Mobil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-initial {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
}
</style>
<?= $this->endSection() ?> 