    <?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-star text-warning mr-2"></i> Kelola Ulasan</h1>
        </div>
        <div class="col-md-6 text-right">
            <span class="badge badge-primary">Total: <?= count($reviews) ?></span>
        </div>
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
    
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Ulasan</h6>
            <div>
                <div class="btn-group" role="group">
                    <button id="filter-btn" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?= site_url('admin/reviews') ?>">Semua</a>
                        <a class="dropdown-item" href="<?= site_url('admin/reviews?status=approved') ?>">Disetujui</a>
                        <a class="dropdown-item" href="<?= site_url('admin/reviews?status=pending') ?>">Menunggu Persetujuan</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="50">ID</th>
                            <th>Mobil</th>
                            <th>Pengguna</th>
                            <th width="100">Rating</th>
                            <th>Ulasan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($reviews)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="text-muted">Belum ada data ulasan</div>
                            </td>
                        </tr>
                        <?php else: ?>
                            <?php foreach($reviews as $review): ?>
                            <tr>
                                <td><?= $review['id'] ?></td>
                                <td><?= $review['brand'] . ' ' . $review['model'] ?></td>
                                <td><?= $review['username'] ?></td>
                                <td>
                                    <div class="text-warning">
                                        <?php for($i=1; $i <= 5; $i++): ?>
                                            <?php if($i <= $review['rating']): ?>
                                                <i class="fas fa-star"></i>
                                            <?php else: ?>
                                                <i class="far fa-star"></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                        <span class="text-dark ml-1"><?= $review['rating'] ?>/5</span>
                                    </div>
                                </td>
                                <td>
                                    <?= substr($review['comment'], 0, 50) . (strlen($review['comment']) > 50 ? '...' : '') ?>
                                </td>
                                <td><?= date('d M Y H:i', strtotime($review['created_at'])) ?></td>
                                <td>
                                    <?php if($review['is_approved']): ?>
                                        <span class="badge badge-success">Disetujui</span>
                                    <?php else: ?>
                                        <span class="badge badge-warning">Menunggu</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= site_url('admin/reviews/details/' . $review['id']) ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
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
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#dataTable').DataTable();
});
</script>
<?= $this->endSection() ?> 