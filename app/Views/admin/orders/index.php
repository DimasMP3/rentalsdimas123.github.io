<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Orders</h1>
        <a href="<?= site_url('admin/orders/export-excel') ?>" class="btn btn-success">
            <i class="fas fa-file-excel me-1"></i> Export Excel
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
            
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Car</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Payment Method</th>
                            <th>Payment Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Load PaymentModel to get payment details
                        $paymentModel = new \App\Models\PaymentModel();
                        
                        foreach ($orders as $order): 
                            // Get payment info for this order
                            $payment = $paymentModel->where('order_id', $order['id'])->first();
                        ?>
                        <tr>
                            <td><?= $order['id'] ?></td>
                            <td><?= $order['user_name'] ?></td>
                            <td><?= $order['brand'] . ' ' . $order['model'] ?></td>
                            <td><?= date('d M Y', strtotime($order['start_date'])) ?></td>
                            <td><?= date('d M Y', strtotime($order['end_date'])) ?></td>
                            <td>Rp <?= number_format($order['total_price'], 0, ',', '.') ?></td>
                            <td>
                                <span class="badge bg-<?= $order['status'] == 'pending' ? 'warning' : ($order['status'] == 'approved' ? 'success' : ($order['status'] == 'completed' ? 'info' : 'danger')) ?>">
                                    <?= ucfirst($order['status']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if (!empty($order['payment_method'])): ?>
                                    <span class="badge bg-light text-dark">
                                        <?= $order['payment_method_display'] ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-<?= $order['payment_status'] == 'paid' ? 'success' : ($order['payment_status'] == 'pending' ? 'warning' : 'danger') ?>">
                                    <?= $order['payment_status'] == 'paid' ? 'Lunas' : ($order['payment_status'] == 'pending' ? 'Menunggu' : 'Gagal') ?>
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?= site_url('admin/orders/' . $order['id']) ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <?php if ($payment && !empty($payment['payment_proof'])): ?>
                                    <a href="#" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#proofModal<?= $order['id'] ?>">
                                        <i class="fas fa-image"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if ($order['status'] == 'pending'): ?>
                                    <button type="button" class="btn btn-sm btn-success" onclick="updateStatus(<?= $order['id'] ?>, 'approved')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <?php endif; ?>
                                    <?php if ($order['status'] == 'approved'): ?>
                                    <button type="button" class="btn btn-sm btn-primary" onclick="updateStatus(<?= $order['id'] ?>, 'completed')">
                                        <i class="fas fa-flag-checkered"></i>
                                    </button>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Payment Proof Modal -->
                                <?php if ($payment && !empty($payment['payment_proof'])): ?>
                                <div class="modal fade" id="proofModal<?= $order['id'] ?>" tabindex="-1" aria-labelledby="proofModalLabel<?= $order['id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="proofModalLabel<?= $order['id'] ?>">Payment Proof - Order #<?= $order['id'] ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img src="<?= base_url('uploads/payments/' . $payment['payment_proof']) ?>" class="img-fluid" alt="Payment Proof">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <?php if ($order['payment_status'] != 'paid'): ?>
                                                <button type="button" class="btn btn-success" onclick="approvePayment(<?= $order['id'] ?>)">Approve Payment</button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function updateStatus(orderId, status) {
    if (confirm('Are you sure you want to update this order status?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `<?= site_url('admin/orders/update-status/') ?>${orderId}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '<?= csrf_token() ?>';
        csrfToken.value = '<?= csrf_hash() ?>';
        
        const statusInput = document.createElement('input');
        statusInput.type = 'hidden';
        statusInput.name = 'status';
        statusInput.value = status;
        
        form.appendChild(csrfToken);
        form.appendChild(statusInput);
        document.body.appendChild(form);
        form.submit();
    }
}

function approvePayment(orderId) {
    if (confirm('Are you sure you want to approve this payment?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `<?= site_url('admin/orders/approve-payment/') ?>${orderId}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '<?= csrf_token() ?>';
        csrfToken.value = '<?= csrf_hash() ?>';
        
        form.appendChild(csrfToken);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
<?= $this->endSection() ?> 