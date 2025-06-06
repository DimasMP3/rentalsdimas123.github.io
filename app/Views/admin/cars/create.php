<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Add New Car</h1>
        <a href="<?= site_url('admin/cars') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Cars
        </a>
    </div>
    
    <div class="card">
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
            
            <form action="<?= site_url('admin/cars/store') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="brand" class="form-label">Brand</label>
                        <input type="text" name="brand" id="brand" class="form-control" value="<?= old('brand') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="model" class="form-label">Model</label>
                        <input type="text" name="model" id="model" class="form-control" value="<?= old('model') ?>" required>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="year" class="form-label">Year</label>
                        <input type="number" name="year" id="year" class="form-control" value="<?= old('year') ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="license_plate" class="form-label">License Plate</label>
                        <input type="text" name="license_plate" id="license_plate" class="form-control" value="<?= old('license_plate') ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="daily_rate" class="form-label">Daily Rate (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                            <input type="number" name="daily_rate" id="daily_rate" class="form-control" step="0.01" value="<?= old('daily_rate') ?>" required>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select name="category_id" id="category_id" class="form-select" required>
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>" <?= old('category_id') == $category['id'] ? 'selected' : '' ?>>
                            <?= $category['name'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4"><?= old('description') ?></textarea>
                </div>
                
                <div class="mb-3">
                    <label for="image" class="form-label">Car Image</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
                    <div class="form-text">Upload a clear image of the car. Max size: 4MB.</div>
                </div>
                
                <button type="submit" class="btn btn-primary">Add Car</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
