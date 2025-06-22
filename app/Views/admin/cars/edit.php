<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title">Edit Car</h1>
        <a href="<?= site_url('admin/cars') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Cars
        </a>
    </div>
    
    <?php if (session()->has('errors')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            <?php foreach (session('errors') as $error): ?>
            <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>
    
    <?php if (session()->has('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>
    
    <form action="<?= site_url('admin/cars/update/' . $car['id']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <div class="row">
            <!-- Car Information -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-car me-2 text-primary"></i> Car Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="brand" class="form-label fw-bold">Brand</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                    <input type="text" name="brand" id="brand" class="form-control" value="<?= old('brand', $car['brand']) ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="model" class="form-label fw-bold">Model</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-car-side"></i></span>
                                    <input type="text" name="model" id="model" class="form-control" value="<?= old('model', $car['model']) ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label for="year" class="form-label fw-bold">Year</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="number" name="year" id="year" class="form-control" value="<?= old('year', $car['year']) ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="license_plate" class="form-label fw-bold">License Plate</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    <input type="text" name="license_plate" id="license_plate" class="form-control" value="<?= old('license_plate', $car['license_plate']) ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="daily_rate" class="form-label fw-bold">Daily Rate - 24 jam dalam/luar kota (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                                    <input type="number" name="daily_rate" id="daily_rate" class="form-control" step="0.01" value="<?= old('daily_rate', $car['daily_rate']) ?>" required>
                                </div>
                                <small class="text-muted">*Harga untuk 24 jam dalam/luar kota. Harian + Supir = 200% dari harga ini.</small>
                            </div>
                        </div>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="category_id" class="form-label fw-bold">Category</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-tags"></i></span>
                                    <select name="category_id" id="category_id" class="form-select" required>
                                        <option value="">Select Category</option>
                                        <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>" <?= old('category_id', $car['category_id']) == $category['id'] ? 'selected' : '' ?>>
                                            <?= $category['name'] ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label fw-bold">Status</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                                    <select name="status" id="status" class="form-select" required>
                                        <option value="available" <?= old('status', $car['status']) == 'available' ? 'selected' : '' ?>>Available</option>
                                        <option value="rented" <?= old('status', $car['status']) == 'rented' ? 'selected' : '' ?>>Rented</option>
                                        <option value="maintenance" <?= old('status', $car['status']) == 'maintenance' ? 'selected' : '' ?>>Maintenance</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                                <textarea name="description" id="description" class="form-control" rows="4"><?= old('description', $car['description']) ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Discount Settings Section -->
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-percent me-2 text-primary"></i> Discount Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> Set discount percentages for specific days of the week. Leave blank or set to 0 for no discount.
                        </div>
                        
                        <?php 
                        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                        $dayLabels = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                        
                        // Get current discounts
                        $carDiscountModel = new \App\Models\CarDiscountModel();
                        $currentDiscounts = $carDiscountModel->getCarDiscountDays($car['id']);
                        
                        // Create a lookup array for easy access
                        $discountPercentages = [];
                        foreach ($currentDiscounts as $discount) {
                            $discountPercentages[$discount['discount_day']] = $discount['discount_percentage'];
                        }
                        ?>
                        
                        <div class="row g-3">
                            <?php foreach ($days as $index => $day): ?>
                            <div class="col-md-6 mb-3">
                                <div class="card border shadow-sm">
                                    <div class="card-body">
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input discount-day-toggle" type="checkbox" 
                                                id="toggle_<?= $day ?>" 
                                                name="toggle_discount[<?= $day ?>]"
                                                data-day="<?= $day ?>" 
                                                value="1"
                                                <?= isset($discountPercentages[$day]) ? 'checked' : '' ?>>
                                            <label class="form-check-label fw-bold" for="toggle_<?= $day ?>"><?= $dayLabels[$index] ?></label>
                                        </div>
                                        <div class="input-group <?= isset($discountPercentages[$day]) ? '' : 'discount-input-hidden' ?>" id="input_group_<?= $day ?>">
                                            <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                            <input type="number" name="discounts[<?= $day ?>]" 
                                                class="form-control" placeholder="e.g. 10" 
                                                min="0" max="100" step="0.01"
                                                value="<?= isset($discountPercentages[$day]) ? $discountPercentages[$day] : '' ?>">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Car Image Section -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-image me-2 text-primary"></i> Car Image</h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Current Image</label>
                            <div class="mt-2 position-relative">
                                <img src="<?= base_url('uploads/cars/' . $car['image']) ?>" alt="<?= $car['brand'] . ' ' . $car['model'] ?>" class="img-fluid rounded shadow" style="max-height: 250px;">
                                <div class="mt-2 text-muted small">
                                    <?= $car['brand'] . ' ' . $car['model'] . ' (' . $car['year'] . ')' ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label fw-bold">New Image (optional)</label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*">
                            <div class="form-text mt-2">
                                <i class="fas fa-info-circle me-1"></i> Upload a new image only if you want to replace the current one. Max size: 4MB.
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i> Update Car
                    </button>
                    <a href="<?= site_url('admin/cars') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i> Cancel
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
.discount-input-hidden {
    display: none;
}

.card {
    transition: all 0.3s ease;
}

.border {
    border-color: #dee2e6 !important;
}

.form-label {
    margin-bottom: 0.3rem;
}

.input-group-text {
    background-color: #f8f9fa;
    border-right: none;
}

.form-control, .form-select {
    border-left: none;
}

.form-control:focus, .form-select:focus {
    box-shadow: none;
    border-color: #ced4da;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle discount day toggle switches
    document.querySelectorAll('.discount-day-toggle').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const day = this.getAttribute('data-day');
            const inputGroup = document.getElementById('input_group_' + day);
            const discountInput = inputGroup.querySelector('input[type="number"]');
            
            if (this.checked) {
                inputGroup.classList.remove('discount-input-hidden');
                // If input is empty, set default value of 10%
                if (!discountInput.value) {
                    discountInput.value = '10.00';
                }
            } else {
                inputGroup.classList.add('discount-input-hidden');
                // Clear the input value when unchecked
                discountInput.value = '';
            }
        });
    });
    
    // Ensure form doesn't submit empty values for unchecked days
    document.querySelector('form').addEventListener('submit', function(e) {
        document.querySelectorAll('.discount-day-toggle').forEach(function(checkbox) {
            if (!checkbox.checked) {
                const day = checkbox.getAttribute('data-day');
                const inputGroup = document.getElementById('input_group_' + day);
                const discountInput = inputGroup.querySelector('input[type="number"]');
                discountInput.disabled = true; // Disable so it doesn't get submitted
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
