<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Kategori</h1>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit Kategori</h6>
                </div>
                <div class="card-body">
                    <?php if (session()->has('errors')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session('errors') as $error): ?>
                            <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (session()->has('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>
                    
                    <form action="<?= site_url('admin/categories/update/' . $category['id']) ?>" method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Kategori</label>
                            <input type="text" name="name" id="name" class="form-control" value="<?= old('name', $category['name']) ?>" required>
                            <div class="form-text">Nama kategori harus unik.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea name="description" id="description" class="form-control" rows="4" required><?= old('description', $category['description']) ?></textarea>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?= site_url('admin/categories') ?>" class="btn btn-secondary me-md-2">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Kategori</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>ID Kategori:</strong> <?= $category['id'] ?>
                    </div>
                    <div class="mb-3">
                        <strong>Tanggal Dibuat:</strong> <?= date('d/m/Y H:i', strtotime($category['created_at'])) ?>
                    </div>
                    <div class="mb-3">
                        <strong>Terakhir Diupdate:</strong> <?= date('d/m/Y H:i', strtotime($category['updated_at'])) ?>
                    </div>
                    
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle me-2"></i> Perubahan pada kategori akan mempengaruhi semua mobil yang termasuk dalam kategori ini.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 