<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Order Details</h1>
        <a href="<?= site_url('admin/orders') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Orders
        </a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <?php if (session()->has('success')): ?>
            <div class="alert alert-success">
                <?= session('success') ?>
            </div>
            <?php endif; ?>
            
            <?php if (session()->has('error')): ?>
            <div class="alert alert-danger">
                <?= session('error') ?>
            </div>
            <?php endif; ?>
            
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-3">Order Information</h5>
                    <table class="table">
                        <tr>
                            <th>Order ID</th>
                            <td><?= $order['id'] ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge bg-<?= $order['status'] == 'pending' ? 'warning' : ($order['status'] == 'approved' ? 'success' : ($order['status'] == 'completed' ? 'info' : 'danger')) ?>">
                                    <?= ucfirst($order['status']) ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Start Date</th>
                            <td><?= date('d M Y', strtotime($order['start_date'])) ?></td>
                        </tr>
                        <tr>
                            <th>End Date</th>
                            <td><?= date('d M Y', strtotime($order['end_date'])) ?></td>
                        </tr>
                        <tr>
                            <th>Total Price</th>
                            <td>Rp <?= number_format($order['total_price'], 0, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td><?= date('d M Y H:i', strtotime($order['created_at'])) ?></td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td><?= date('d M Y H:i', strtotime($order['updated_at'])) ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="mb-3">User Information</h5>
                    <table class="table">
                        <tr>
                            <th>Name</th>
                            <td><?= $order['user_name'] ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= $order['user_email'] ?></td>
                        </tr>
                        <?php if (!empty($order['user_phone'])): ?>
                        <tr>
                            <th>Phone</th>
                            <td><?= $order['user_phone'] ?></td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
            
            <h5 class="mt-4 mb-3">Car Information</h5>
            <div class="row">
                <div class="col-md-3">
                    <?php if(!empty($order['image'])): ?>
                    <img src="<?= base_url('uploads/cars/' . $order['image']) ?>" class="img-fluid rounded" alt="<?= $order['brand'] . ' ' . $order['model'] ?>">
                    <?php else: ?>
                    <div class="bg-light text-center py-5 rounded">
                        <i class="fas fa-car fa-4x text-secondary"></i>
                        <p class="mt-2 text-muted">No image available</p>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-9">
                    <table class="table">
                        <tr>
                            <th>Brand</th>
                            <td><?= $order['brand'] ?></td>
                        </tr>
                        <tr>
                            <th>Model</th>
                            <td><?= $order['model'] ?></td>
                        </tr>
                        <tr>
                            <th>Year</th>
                            <td><?= $order['year'] ?></td>
                        </tr>
                        <tr>
                            <th>License Plate</th>
                            <td><?= $order['license_plate'] ?></td>
                        </tr>
                        <tr>
                            <th>Daily Rate</th>
                            <td>Rp <?= number_format($order['daily_rate'], 0, ',', '.') ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Payment Information -->
            <h5 class="mt-4 mb-3">Payment Information</h5>
            <div class="row">
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th>Payment Method</th>
                            <td>
                                <?php if (!empty($order['payment_method'])): ?>
                                <span class="badge bg-light text-dark">
                                    <?= ucfirst(str_replace('_', ' ', $order['payment_method'])) ?>
                                </span>
                                <?php else: ?>
                                <span class="text-muted">Not specified</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Payment Status</th>
                            <td>
                                <span class="badge bg-<?= $order['payment_status'] == 'paid' ? 'success' : ($order['payment_status'] == 'pending' ? 'warning' : 'danger') ?>">
                                    <?= $order['payment_status'] == 'paid' ? 'Lunas' : ($order['payment_status'] == 'pending' ? 'Menunggu Pembayaran' : 'Gagal') ?>
                                </span>
                            </td>
                        </tr>
                        <?php if (isset($payment) && $payment): ?>
                        <tr>
                            <th>Payment Date</th>
                            <td><?= $payment['payment_date'] ? date('d M Y H:i', strtotime($payment['payment_date'])) : 'Belum dibayar' ?></td>
                        </tr>
                        <?php if (!empty($order['notes'])): ?>
                        <tr>
                            <th>Notes</th>
                            <td><?= $order['notes'] ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php endif; ?>
                    </table>
                </div>
                
                <div class="col-md-6">
                    <?php if (isset($payment) && !empty($payment['payment_proof'])): ?>
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Payment Proof</h6>
                        </div>
                        <div class="card-body text-center">
                            <img src="<?= base_url('uploads/payments/' . $payment['payment_proof']) ?>" class="img-fluid rounded mb-3" style="max-height: 300px;" alt="Bukti Pembayaran">
                            <?php if ($order['payment_status'] != 'paid'): ?>
                            <form action="<?= site_url('admin/orders/approve-payment/' . $order['id']) ?>" method="post" class="mt-3">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check-circle me-2"></i> Approve Payment
                                </button>
                            </form>
                            <?php else: ?>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i> Payment has been approved
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i> No payment proof has been uploaded yet.
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Status Update Form -->
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-sync-alt me-2"></i>Update Order Status</h5>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('admin/orders/update-status/' . $order['id']) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="pending" <?= ($order['status'] == 'pending') ? 'selected' : '' ?>>Pending</option>
                                <option value="approved" <?= ($order['status'] == 'approved') ? 'selected' : '' ?>>Approved</option>
                                <option value="completed" <?= ($order['status'] == 'completed') ? 'selected' : '' ?>>Completed</option>
                                <option value="cancelled" <?= ($order['status'] == 'cancelled') ? 'selected' : '' ?>>Cancelled</option>
                            </select>
                            <div class="form-text">Changing status to "Approved" will mark the car as rented. Changing to "Completed" will make the car available again.</div>
                        </div>
                        <div class="mb-3">
                            <label for="attachment" class="form-label">Attachment</label>
                            <input type="file" class="form-control" id="attachment" name="attachment" accept=".png,.jpg,.jpeg">
                            <div class="form-text">Upload file format: PNG, JPG only</div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Status
                        </button>
                    </form>
                </div>
            </div>
            
            <?php if ($order['status'] == 'completed' && $order['payment_status'] == 'paid'): ?>
            <!-- Remove the old upload section for completed status -->
            <?php endif; ?>
            
            <!-- Display uploaded attachment -->
            <?php if (!empty($order['attachment'])): ?>
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Attachment</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <?php $ext = pathinfo($order['attachment'], PATHINFO_EXTENSION); ?>
                                <?php if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png'])): ?>
                                    <img src="<?= base_url('uploads/attachments/' . $order['attachment']) ?>" class="img-fluid rounded" alt="Attachment">
                                <?php else: ?>
                                    <i class="fas fa-file fa-3x text-secondary"></i>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <a href="<?= base_url('uploads/attachments/' . $order['attachment']) ?>" class="btn btn-primary" download>
                                <i class="fas fa-download me-2"></i> Download Attachment
                            </a>
                            <p class="mt-2">Filename: <?= $order['attachment'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 