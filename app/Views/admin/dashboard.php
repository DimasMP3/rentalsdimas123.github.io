<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <h1 class="mb-4">Admin Dashboard</h1>
    
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-0">Total Cars</h6>
                            <h2 class="mt-2 mb-0"><?= $statistics['total_cars'] ?></h2>
                        </div>
                        <i class="fas fa-car fa-3x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="<?= site_url('admin/cars') ?>" class="text-white">View Details</a>
                    <i class="fas fa-arrow-circle-right text-white"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-0">Available Cars</h6>
                            <h2 class="mt-2 mb-0"><?= $statistics['available_cars'] ?></h2>
                        </div>
                        <i class="fas fa-check-circle fa-3x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="<?= site_url('admin/cars?status=available') ?>" class="text-white">View Details</a>
                    <i class="fas fa-arrow-circle-right text-white"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-0">Active Rentals</h6>
                            <h2 class="mt-2 mb-0"><?= $statistics['active_rentals'] ?></h2>
                        </div>
                        <i class="fas fa-calendar-check fa-3x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="<?= site_url('admin/rentals?status=active') ?>" class="text-white">View Details</a>
                    <i class="fas fa-arrow-circle-right text-white"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-0">Total Revenue</h6>
                            <h2 class="mt-2 mb-0">Rp <?= number_format($statistics['total_revenue'], 0, ',', '.') ?></h2>
                        </div>
                        <i class="fas fa-dollar-sign fa-3x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="<?= site_url('admin/payments') ?>" class="text-white">View Details</a>
                    <i class="fas fa-arrow-circle-right text-white"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Rentals</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Car</th>
                                    <th>Pickup Date</th>
                                    <th>Return Date</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($statistics['recent_rentals'] as $rental): ?>
                                <tr>
                                    <td><?= $rental['id'] ?></td>
                                    <td><?= $rental['user_name'] ?></td>
                                    <td><?= $rental['brand'] . ' ' . $rental['model'] ?></td>
                                    <td><?= date('M d, Y', strtotime($rental['start_date'])) ?></td>
                                    <td><?= date('M d, Y', strtotime($rental['end_date'])) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $rental['status'] == 'active' ? 'success' : ($rental['status'] == 'pending' ? 'warning' : ($rental['status'] == 'completed' ? 'primary' : 'danger')) ?>">
                                            <?= ucfirst($rental['status']) ?>
                                        </span>
                                    </td>
                                    <td>Rp <?= number_format($rental['amount'], 0, ',', '.') ?></td>
                                    <td>
                                        <a href="<?= site_url('admin/rentals/' . $rental['id']) ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?= site_url('admin/rentals') ?>" class="btn btn-primary">View All Rentals</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="<?= site_url('admin/cars/create') ?>" class="list-group-item list-group-item-action">
                            <i class="fas fa-plus-circle me-2"></i> Add New Car
                        </a>
                        <a href="<?= site_url('admin/categories/create') ?>" class="list-group-item list-group-item-action">
                            <i class="fas fa-tags me-2"></i> Add New Category
                        </a>
                        <a href="<?= site_url('admin/users') ?>" class="list-group-item list-group-item-action">
                            <i class="fas fa-users me-2"></i> Manage Users
                        </a>
                        <a href="<?= site_url('admin/reports') ?>" class="list-group-item list-group-item-action">
                            <i class="fas fa-chart-bar me-2"></i> Generate Reports
                        </a>
                        <a href="<?= site_url('admin/settings') ?>" class="list-group-item list-group-item-action">
                            <i class="fas fa-cogs me-2"></i> System Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
