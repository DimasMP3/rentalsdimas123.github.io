<?= $this->extend('admin/layouts/default') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6><?= isset($car) ? 'Edit Mobil' : 'Tambah Mobil Baru' ?></h6>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                    <?php endif; ?>
                    
                    <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>
                    
                    <form action="<?= isset($car) ? site_url('admin/cars/update/' . $car['id']) : site_url('admin/cars/store') ?>" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="brand" class="form-label">Merek</label>
                                    <input type="text" name="brand" id="brand" class="form-control" value="<?= isset($car) ? $car['brand'] : old('brand') ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="model" class="form-label">Model</label>
                                    <input type="text" name="model" id="model" class="form-control" value="<?= isset($car) ? $car['model'] : old('model') ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="year" class="form-label">Tahun</label>
                                    <input type="text" name="year" id="year" class="form-control" value="<?= isset($car) ? $car['year'] : old('year') ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="license_plate" class="form-label">Nomor Polisi</label>
                                    <input type="text" name="license_plate" id="license_plate" class="form-control" value="<?= isset($car) ? $car['license_plate'] : old('license_plate') ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="daily_rate" class="form-label">Tarif Harian</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="daily_rate" id="daily_rate" class="form-control" value="<?= isset($car) ? $car['daily_rate'] : old('daily_rate') ?>" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Kategori</label>
                                    <select name="category_id" id="category_id" class="form-select" required>
                                        <option value="">Pilih Kategori</option>
                                        <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>" <?= (isset($car) && $car['category_id'] == $category['id']) ? 'selected' : (old('category_id') == $category['id'] ? 'selected' : '') ?>>
                                            <?= $category['name'] ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-select" required>
                                        <option value="available" <?= (isset($car) && $car['status'] == 'available') ? 'selected' : (old('status') == 'available' ? 'selected' : '') ?>>Tersedia</option>
                                        <option value="rented" <?= (isset($car) && $car['status'] == 'rented') ? 'selected' : (old('status') == 'rented' ? 'selected' : '') ?>>Disewa</option>
                                        <option value="maintenance" <?= (isset($car) && $car['status'] == 'maintenance') ? 'selected' : (old('status') == 'maintenance' ? 'selected' : '') ?>>Pemeliharaan</option>
                                        <option value="pending" <?= (isset($car) && $car['status'] == 'pending') ? 'selected' : (old('status') == 'pending' ? 'selected' : '') ?>>Pending</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="description" class="form-label">Deskripsi</label>
                                    <textarea name="description" id="description" class="form-control" rows="4"><?= isset($car) ? $car['description'] : old('description') ?></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="image" class="form-label">Foto Mobil</label>
                                    <?php if(isset($car) && $car['image']): ?>
                                    <div class="mb-2">
                                        <img src="<?= base_url('uploads/cars/' . $car['image']) ?>" alt="Current Image" class="img-thumbnail" style="max-height: 100px">
                                    </div>
                                    <?php endif; ?>
                                    <input type="file" name="image" id="image" class="form-control" <?= !isset($car) ? 'required' : '' ?>>
                                    <?php if(isset($car)): ?>
                                    <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Discount Days Section -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Atur Diskon</h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-muted small">Pilih hari-hari dan persentase diskon untuk mobil ini</p>
                                        
                                        <div class="row">
                                            <?php 
                                            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                            $dayLabels = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                                            $discountDays = isset($car) ? get_discount_days_for_car($car['id']) : [];
                                            
                                            // Get discount percentages
                                            $discountPercentages = [];
                                            if (isset($car)) {
                                                $carDiscountModel = new \App\Models\CarDiscountModel();
                                                $currentDiscounts = $carDiscountModel->getCarDiscountDays($car['id']);
                                                foreach ($currentDiscounts as $discount) {
                                                    $discountPercentages[$discount['discount_day']] = $discount['discount_percentage'];
                                                }
                                            }
                                            
                                            foreach ($days as $index => $day):
                                            ?>
                                            <div class="col-md-6 mb-3">
                                                <div class="card border">
                                                    <div class="card-body">
                                                        <div class="form-check form-switch mb-2">
                                                            <input class="form-check-input discount-day-toggle" type="checkbox" 
                                                                id="toggle_<?= $day ?>" 
                                                                data-day="<?= $day ?>" 
                                                                <?= in_array($day, $discountDays) ? 'checked' : '' ?>>
                                                            <label class="form-check-label" for="toggle_<?= $day ?>"><?= $dayLabels[$index] ?></label>
                                                        </div>
                                                        <div class="input-group <?= in_array($day, $discountDays) ? '' : 'discount-input-hidden' ?>" id="input_group_<?= $day ?>">
                                                            <span class="input-group-text">Diskon</span>
                                                            <input type="number" name="discounts[<?= $day ?>]" 
                                                                class="form-control" placeholder="cth. 10" 
                                                                min="0" max="100" step="0.01"
                                                                value="<?= isset($discountPercentages[$day]) ? $discountPercentages[$day] : '10.00' ?>">
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
                        </div>
                        
                        <div class="d-flex justify-content-end mt-4">
                            <a href="<?= site_url('admin/cars') ?>" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .discount-days-container {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
    }
    
    .form-check-inline {
        margin-right: 1.5rem;
    }
    
    .discount-input-hidden {
        display: none;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle discount day toggle switches
    document.querySelectorAll('.discount-day-toggle').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const day = this.getAttribute('data-day');
            const inputGroup = document.getElementById('input_group_' + day);
            
            if (this.checked) {
                inputGroup.classList.remove('discount-input-hidden');
            } else {
                inputGroup.classList.add('discount-input-hidden');
                // Clear the input value when unchecked
                inputGroup.querySelector('input[type="number"]').value = '';
            }
        });
    });
});
</script>
<?= $this->endSection() ?> 