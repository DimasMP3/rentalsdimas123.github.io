<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Cars</h1>
        <a href="<?= site_url('admin/cars/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i> Add New Car
        </a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Brand</th>
                            <th>Model</th>
                            <th>Year</th>
                            <th>License Plate</th>
                            <th>Daily Rate</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cars as $car): ?>
                        <tr>
                            <td><?= $car['id'] ?></td>
                            <td>
                                <img src="<?= base_url('uploads/cars/' . $car['image']) ?>" alt="<?= $car['brand'] . ' ' . $car['model'] ?>" class="img-thumbnail" width="80">
                            </td>
                            <td><?= $car['brand'] ?></td>
                            <td><?= $car['model'] ?></td>
                            <td><?= $car['year'] ?></td>
                            <td><?= $car['license_plate'] ?></td>
                            <td>Rp <?= number_format($car['daily_rate'], 0, ',', '.') ?></td>
                            <td>
                                <span class="badge bg-<?= $car['status'] == 'available' ? 'success' : ($car['status'] == 'rented' ? 'warning' : 'danger') ?>">
                                    <?= ucfirst($car['status']) ?>
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?= site_url('admin/cars/edit/' . $car['id']) ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= site_url('admin/cars/delete/' . $car['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this car?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
