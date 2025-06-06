<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Kategori Baru</h1>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Kategori</h6>
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
                    
                    <form action="<?= site_url('admin/categories/store') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Kategori</label>
                            <input type="text" name="name" id="name" class="form-control" value="<?= old('name') ?>" required>
                            <div class="form-text">Nama kategori harus unik.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea name="description" id="description" class="form-control" rows="4" required><?= old('description') ?></textarea>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?= site_url('admin/categories') ?>" class="btn btn-secondary me-md-2">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Petunjuk</h6>
                </div>
                <div class="card-body">
                    <p>Kategori digunakan untuk mengelompokkan mobil berdasarkan jenisnya, contoh:</p>
                    <ul>
                        <li>SUV</li>
                        <li>Sedan</li>
                        <li>MPV</li>
                        <li>Hatchback</li>
                        <li>Sport</li>
                    </ul>
                    <p>Kategori yang sudah dibuat akan muncul di menu filter pencarian mobil untuk memudahkan pelanggan menemukan jenis mobil yang diinginkan.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 