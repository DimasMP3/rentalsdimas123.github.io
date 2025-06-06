<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Detail Kategori</h1>
    
    <?php if (session()->has('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Kategori</h6>
                    <div>
                        <a href="<?= site_url('admin/categories/edit/' . $category['id']) ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <?php if (count($category['cars']) === 0): ?>
                        <a href="<?= site_url('admin/categories/delete/' . $category['id']) ?>" class="btn btn-sm btn-danger" 
                           onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                            <i class="fas fa-trash"></i> Hapus
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">ID</th>
                            <td><?= $category['id'] ?></td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td><?= $category['name'] ?></td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td><?= $category['description'] ?></td>
                        </tr>
                        <tr>
                            <th>Jumlah Mobil</th>
                            <td>
                                <span class="badge bg-primary"><?= count($category['cars']) ?></span>
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Dibuat</th>
                            <td><?= date('d/m/Y H:i', strtotime($category['created_at'])) ?></td>
                        </tr>
                        <tr>
                            <th>Terakhir Diupdate</th>
                            <td><?= date('d/m/Y H:i', strtotime($category['updated_at'])) ?></td>
                        </tr>
                    </table>
                    
                    <div class="mt-3">
                        <a href="<?= site_url('admin/categories') ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Mobil dalam Kategori Ini</h6>
                </div>
                <div class="card-body">
                    <?php if (count($category['cars']) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Merek</th>
                                    <th>Model</th>
                                    <th>Tahun</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($category['cars'] as $car): ?>
                                <tr>
                                    <td><?= $car['id'] ?></td>
                                    <td><?= $car['brand'] ?></td>
                                    <td><?= $car['model'] ?></td>
                                    <td><?= $car['year'] ?></td>
                                    <td>
                                        <a href="<?= site_url('admin/cars/edit/' . $car['id']) ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> Tidak ada mobil dalam kategori ini.
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 