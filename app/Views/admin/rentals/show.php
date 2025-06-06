<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Detail Penyewaan #<?= $rental['id'] ?></h1>
    
    <?php if (session()->has('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>
    
    <?php if (session()->has('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Penyewaan</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Status</th>
                            <td>
                                <span class="badge badge-<?= ($rental['status'] == 'active') ? 'success' : (($rental['status'] == 'pending') ? 'warning' : (($rental['status'] == 'completed') ? 'primary' : 'danger')) ?>">
                                    <?= ucfirst($rental['status']) ?>
                                </span>
                                <button type="button" class="btn btn-sm btn-primary float-end" data-bs-toggle="modal" data-bs-target="#statusModal">
                                    <i class="fas fa-edit"></i> Update Status
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Dibuat</th>
                            <td><?= date('d/m/Y H:i', strtotime($rental['created_at'])) ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal Pengambilan</th>
                            <td><?= date('d/m/Y', strtotime($rental['pickup_date'])) ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal Pengembalian</th>
                            <td><?= date('d/m/Y', strtotime($rental['return_date'])) ?></td>
                        </tr>
                        <tr>
                            <th>Durasi</th>
                            <td>
                                <?php
                                $start = new DateTime($rental['pickup_date']);
                                $end = new DateTime($rental['return_date']);
                                $days = $end->diff($start)->days;
                                echo $days . ' hari';
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Total Biaya</th>
                            <td>Rp <?= number_format($rental['total_amount'], 0, ',', '.') ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Customer</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Nama</th>
                            <td><?= $rental['user_name'] ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= $rental['email'] ?></td>
                        </tr>
                        <tr>
                            <th>Telepon</th>
                            <td><?= $rental['phone'] ?></td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td><?= $rental['address'] ?></td>
                        </tr>
                        <tr>
                            <th>No. SIM</th>
                            <td><?= $rental['license_number'] ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Mobil</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Mobil</th>
                            <td><?= $rental['brand'] . ' ' . $rental['model'] . ' (' . $rental['year'] . ')' ?></td>
                        </tr>
                        <tr>
                            <th>No. Plat</th>
                            <td><?= $rental['license_plate'] ?></td>
                        </tr>
                        <tr>
                            <th>Harga per Hari</th>
                            <td>Rp <?= number_format($rental['price_per_day'], 0, ',', '.') ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Pembayaran</h6>
                </div>
                <div class="card-body">
                    <?php if ($payment): ?>
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Status</th>
                            <td>
                                <span class="badge badge-<?= ($payment['status'] == 'completed') ? 'success' : (($payment['status'] == 'pending') ? 'warning' : 'danger') ?>">
                                    <?= ucfirst($payment['status']) ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Metode Pembayaran</th>
                            <td><?= ucfirst(str_replace('_', ' ', $payment['payment_method'])) ?></td>
                        </tr>
                        <tr>
                            <th>Jumlah</th>
                            <td>Rp <?= number_format($payment['amount'], 0, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal Pembayaran</th>
                            <td><?= $payment['payment_date'] ? date('d/m/Y H:i', strtotime($payment['payment_date'])) : '-' ?></td>
                        </tr>
                    </table>
                    <div class="mt-3">
                        <a href="<?= site_url('admin/payments/' . $payment['id']) ?>" class="btn btn-info">
                            <i class="fas fa-eye"></i> Lihat Detail Pembayaran
                        </a>
                    </div>
                    <?php else: ?>
                    <div class="alert alert-info mb-0">
                        Belum ada pembayaran untuk penyewaan ini.
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mb-4">
        <a href="<?= site_url('admin/rentals') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<!-- Status Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Update Status Penyewaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= site_url('admin/rentals/update-status/' . $rental['id']) ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="pending" <?= $rental['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="active" <?= $rental['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="completed" <?= $rental['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                            <option value="cancelled" <?= $rental['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 