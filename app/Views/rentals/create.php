<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Sewa Mobil</h4>
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
                    
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <img src="<?= base_url('uploads/cars/' . $car['image']) ?>" class="img-fluid rounded" alt="<?= $car['brand'] . ' ' . $car['model'] ?>">
                        </div>
                        <div class="col-md-8">
                            <h3><?= $car['brand'] . ' ' . $car['model'] ?></h3>
                            <p class="text-muted"><?= $car['year'] ?> • Plat: <?= $car['license_plate'] ?></p>
                            <h4 class="text-primary">Rp <?= number_format($car['daily_rate'], 0, ',', '.') ?> / hari</h4>
                            <?php 
                            // Load discount days for this car
                            $discountModel = new \App\Models\CarDiscountModel();
                            $discountDays = $discountModel->getCarDiscountDays($car['id']);
                            
                            if (!empty($discountDays)): 
                            ?>
                            <div class="alert alert-success mt-2">
                                <h5><i class="fas fa-tag me-2"></i>Diskon Tersedia!</h5>
                                <p class="mb-0">Mobil ini memiliki diskon khusus pada hari tertentu:</p>
                                <ul class="mb-0">
                                    <?php foreach ($discountDays as $discount): ?>
                                    <li><?= ucfirst($discount['discount_day']) ?>: <?= $discount['discount_percentage'] ?>% off</li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php endif; ?>
                            <p><?= $car['description'] ?></p>
                            
                            <!-- Benefit Information -->
                            <div class="alert alert-info mt-2">
                                <h5><i class="fas fa-gift me-2"></i>Bonus Tersedia!</h5>
                                <p class="mb-0">Setiap penyewaan mobil ini akan mendapatkan benefit tambahan:</p>
                                <ul class="mb-0">
                                    <li>Snack dan minuman gratis</li>
                                    <li>Pengharum mobil premium</li>
                                    <li>Tissue mobil</li>
                                    <li>Payung</li>
                                    <li>Disinfektan dan hand sanitizer</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <form action="<?= site_url('rentals/store') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="car_id" value="<?= $car['id'] ?>">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" min="<?= date('Y-m-d') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">Tanggal Selesai</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" min="<?= date('Y-m-d', strtotime('+1 day')) ?>" required>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Rincian Biaya</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>Tarif harian:</p>
                                        <p>Jumlah hari:</p>
                                        <div id="daily-breakdown" class="d-none">
                                            <!-- Daily breakdown will be inserted here -->
                                        </div>
                                        <p>Subtotal:</p>
                                        <p>Diskon:</p>
                                        <p>Asuransi:</p>
                                        <p class="fw-bold">Total:</p>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <p>Rp <span id="daily-rate"><?= number_format($car['daily_rate'], 0, ',', '.') ?></span></p>
                                        <p><span id="total-days">0</span> hari</p>
                                        <div id="daily-breakdown-values" class="d-none text-end">
                                            <!-- Daily breakdown values will be inserted here -->
                                        </div>
                                        <p>Rp <span id="subtotal">0</span></p>
                                        <p class="text-success">- Rp <span id="discount-amount">0</span></p>
                                        <p>Rp <span id="insurance">0</span></p>
                                        <p class="fw-bold text-primary">Rp <span id="total-amount">0</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Include discount days data for JavaScript -->
                        <div id="discountData" 
                             data-car-id="<?= $car['id'] ?>"
                             data-discount-days='<?= json_encode($discountDays) ?>'
                             class="d-none"></div>
                        
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Metode Pembayaran</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <div class="row payment-options">
                                        <div class="col-md-4 mb-3">
                                            <div class="form-check payment-option">
                                                <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer" required>
                                                <label class="form-check-label w-100" for="bank_transfer">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-university me-2"></i>
                                                        <span>Transfer Bank</span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-check payment-option">
                                                <input class="form-check-input" type="radio" name="payment_method" id="credit_card" value="credit_card">
                                                <label class="form-check-label w-100" for="credit_card">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-credit-card me-2"></i>
                                                        <span>Kartu Kredit</span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-check payment-option">
                                                <input class="form-check-input" type="radio" name="payment_method" id="e_wallet" value="e_wallet">
                                                <label class="form-check-label w-100" for="e_wallet">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-wallet me-2"></i>
                                                        <span>E-Wallet</span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-check payment-option">
                                                <input class="form-check-input" type="radio" name="payment_method" id="qris" value="qris">
                                                <label class="form-check-label w-100" for="qris">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-qrcode me-2"></i>
                                                        <span>QRIS</span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-check payment-option">
                                                <input class="form-check-input" type="radio" name="payment_method" id="paylater" value="paylater">
                                                <label class="form-check-label w-100" for="paylater">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-hand-holding-usd me-2"></i>
                                                        <span>Paylater</span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-check payment-option">
                                                <input class="form-check-input" type="radio" name="payment_method" id="minimarket" value="minimarket">
                                                <label class="form-check-label w-100" for="minimarket">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-store me-2"></i>
                                                        <span>Minimarket</span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="payment_details" class="mt-3">
                                    <!-- Transfer Bank Details -->
                                    <div id="bank_transfer_details" class="payment-detail-section d-none">
                                        <div class="card bg-light mb-3">
                                            <div class="card-body">
                                                <h6 class="card-title">Informasi Transfer Bank</h6>
                                                <div class="mb-3">
                                                    <select name="bank_name" id="bank_select" class="form-select">
                                                        <option value="">Pilih Bank</option>
                                                        <option value="bca">BCA</option>
                                                        <option value="mandiri">Mandiri</option>
                                                        <option value="bni">BNI</option>
                                                        <option value="bri">BRI</option>
                                                    </select>
                                                </div>
                                                
                                                <!-- Bank account details -->
                                                <div id="bank_details" class="mt-3">
                                                    <!-- BCA Details -->
                                                    <div id="bca_details" class="bank-details d-none">
                                                        <div class="alert alert-primary">
                                                            <h6 class="mb-1">BCA</h6>
                                                            <p class="mb-1"><strong>No. Rekening:</strong> 8730 382 910</p>
                                                            <p class="mb-0"><strong>Atas Nama:</strong> PT Rental Mobil Indonesia</p>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Mandiri Details -->
                                                    <div id="mandiri_details" class="bank-details d-none">
                                                        <div class="alert alert-primary">
                                                            <h6 class="mb-1">Mandiri</h6>
                                                            <p class="mb-1"><strong>No. Rekening:</strong> 137-00-1234567-8</p>
                                                            <p class="mb-0"><strong>Atas Nama:</strong> PT Rental Mobil Indonesia</p>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- BNI Details -->
                                                    <div id="bni_details" class="bank-details d-none">
                                                        <div class="alert alert-primary">
                                                            <h6 class="mb-1">BNI</h6>
                                                            <p class="mb-1"><strong>No. Rekening:</strong> 023 827 1365</p>
                                                            <p class="mb-0"><strong>Atas Nama:</strong> PT Rental Mobil Indonesia</p>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- BRI Details -->
                                                    <div id="bri_details" class="bank-details d-none">
                                                        <div class="alert alert-primary">
                                                            <h6 class="mb-1">BRI</h6>
                                                            <p class="mb-1"><strong>No. Rekening:</strong> 034-01-000123-30-9</p>
                                                            <p class="mb-0"><strong>Atas Nama:</strong> PT Rental Mobil Indonesia</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="alert alert-info mt-3">
                                                    <p class="mb-1"><strong>Petunjuk Transfer:</strong></p>
                                                    <p class="mb-1">1. Transfer sesuai jumlah yang tertera ke rekening yang dipilih</p>
                                                    <p class="mb-1">2. Simpan bukti transfer</p>
                                                    <p class="mb-0">3. Upload bukti transfer pada form di bawah</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Credit Card Details -->
                                    <div id="credit_card_details" class="payment-detail-section d-none">
                                        <div class="card bg-light mb-3">
                                            <div class="card-body">
                                                <h6 class="card-title">Detail Kartu Kredit</h6>
                                                <div class="mb-3">
                                                    <label class="form-label">Nomor Kartu</label>
                                                    <input type="text" name="cc_number" class="form-control" placeholder="1234 5678 9012 3456">
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-6">
                                                        <label class="form-label">Tanggal Kadaluarsa</label>
                                                        <input type="text" name="cc_expiry" class="form-control" placeholder="MM/YY">
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label">CVV</label>
                                                        <input type="text" name="cc_cvv" class="form-control" placeholder="123">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nama pada Kartu</label>
                                                    <input type="text" name="cc_name" class="form-control" placeholder="Nama Lengkap">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- E-Wallet Details -->
                                    <div id="e_wallet_details" class="payment-detail-section d-none">
                                        <div class="card bg-light mb-3">
                                            <div class="card-body">
                                                <h6 class="card-title">Pilih E-Wallet</h6>
                                                <div class="mb-3">
                                                    <select name="ewallet_provider" class="form-select">
                                                        <option value="">Pilih Provider</option>
                                                        <option value="gopay">GoPay</option>
                                                        <option value="ovo">OVO</option>
                                                        <option value="dana">DANA</option>
                                                        <option value="shopeepay">ShopeePay</option>
                                                        <option value="linkaja">LinkAja</option>
                                                    </select>
                                                </div>
                                                <div class="alert alert-info">
                                                    <p class="mb-0">Anda akan menerima instruksi pembayaran setelah menekan tombol "Pesan Sekarang"</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- QRIS Details -->
                                    <div id="qris_details" class="payment-detail-section d-none">
                                        <div class="card bg-light mb-3">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Pembayaran QRIS</h6>
                                                <p>Scan kode QR untuk melakukan pembayaran</p>
                                                <div class="mb-3">
                                                    <img src="<?= base_url('assets/images/qris-sample.png') ?>" alt="QRIS Code" class="img-fluid" style="max-width: 200px;">
                                                </div>
                                                <p class="small text-muted">Kode QR yang sebenarnya akan muncul setelah Anda menekan tombol "Pesan Sekarang"</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Paylater Details -->
                                    <div id="paylater_details" class="payment-detail-section d-none">
                                        <div class="card bg-light mb-3">
                                            <div class="card-body">
                                                <h6 class="card-title">Pilih Layanan Paylater</h6>
                                                <div class="mb-3">
                                                    <select name="paylater_provider" class="form-select">
                                                        <option value="">Pilih Provider</option>
                                                        <option value="kredivo">Kredivo</option>
                                                        <option value="akulaku">Akulaku</option>
                                                        <option value="indodana">Indodana</option>
                                                        <option value="gopaylater">GoPay Later</option>
                                                    </select>
                                                </div>
                                                <div class="alert alert-info">
                                                    <p class="mb-0">Anda akan diarahkan ke halaman provider untuk verifikasi setelah menekan tombol "Pesan Sekarang"</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Minimarket Details -->
                                    <div id="minimarket_details" class="payment-detail-section d-none">
                                        <div class="card bg-light mb-3">
                                            <div class="card-body">
                                                <h6 class="card-title">Pilih Minimarket</h6>
                                                <div class="mb-3">
                                                    <select name="minimarket_provider" class="form-select">
                                                        <option value="">Pilih Minimarket</option>
                                                        <option value="indomaret">Indomaret</option>
                                                        <option value="alfamart">Alfamart</option>
                                                        <option value="alfamidi">Alfamidi</option>
                                                    </select>
                                                </div>
                                                <div class="alert alert-info">
                                                    <p class="mb-1"><strong>Cara Pembayaran:</strong></p>
                                                    <p class="mb-1">1. Anda akan mendapatkan kode pembayaran setelah menekan tombol "Pesan Sekarang"</p>
                                                    <p class="mb-1">2. Tunjukkan kode pembayaran ke kasir</p>
                                                    <p class="mb-0">3. Lakukan pembayaran sesuai jumlah yang tertera</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label for="payment_proof" class="form-label">Bukti Pembayaran (Opsional)</label>
                                    <input type="file" name="payment_proof" id="payment_proof" class="form-control" accept="image/*">
                                    <div class="form-text">Anda dapat mengupload bukti pembayaran sekarang atau nanti.</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Pesan Sekarang</button>
                        </div>
                        
                        <!-- Hidden field to store the calculated total price -->
                        <input type="hidden" name="total_price" id="hidden_total_price" value="0">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const dailyRate = parseInt('<?= $car['daily_rate'] ?>');
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const paymentDetailSections = document.querySelectorAll('.payment-detail-section');
    const discountData = JSON.parse(document.getElementById('discountData').getAttribute('data-discount-days'));
    const carId = document.getElementById('discountData').getAttribute('data-car-id');
    
    // Date calculation functions
    function updateDateDifference() {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);
        
        if (startDateInput.value && endDateInput.value) {
            // Calculate the difference in days
            const timeDiff = endDate - startDate;
            const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
            
            if (daysDiff > 0) {
                // Update the rental calculation
                updateRentalCalculation(startDate, endDate, daysDiff);
            }
        }
    }
    
    function getDayName(date) {
        const days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        return days[date.getDay()];
    }
    
    function getDiscountForDay(dayName) {
        for (const discount of discountData) {
            if (discount.discount_day.toLowerCase() === dayName.toLowerCase()) {
                return parseFloat(discount.discount_percentage);
            }
        }
        return 0;
    }
    
    function updateRentalCalculation(startDate, endDate, totalDays) {
        // Update days
        document.getElementById('total-days').textContent = totalDays;
        
        // Calculate daily costs with discounts
        let subtotal = 0;
        let totalDiscount = 0;
        const dailyBreakdownDiv = document.getElementById('daily-breakdown');
        const dailyBreakdownValuesDiv = document.getElementById('daily-breakdown-values');
        
        // Clear previous breakdown
        dailyBreakdownDiv.innerHTML = '';
        dailyBreakdownValuesDiv.innerHTML = '';
        
        // Calculate for each day
        const currentDate = new Date(startDate);
        const dayPrices = [];
        
        for (let i = 0; i < totalDays; i++) {
            const dayName = getDayName(currentDate);
            const discountPercentage = getDiscountForDay(dayName);
            const discountedPrice = discountPercentage > 0 ? 
                dailyRate - (dailyRate * discountPercentage / 100) : 
                dailyRate;
            
            // Add to the running total
            subtotal += discountedPrice;
            if (discountPercentage > 0) {
                totalDiscount += (dailyRate * discountPercentage / 100);
            }
            
            // Store the day price info
            dayPrices.push({
                date: new Date(currentDate),
                dayName: dayName,
                discountPercentage: discountPercentage,
                originalPrice: dailyRate,
                discountedPrice: discountedPrice
            });
            
            // Move to next day
            currentDate.setDate(currentDate.getDate() + 1);
        }
        
        // Show breakdown if we have discounts
        if (totalDiscount > 0) {
            dailyBreakdownDiv.classList.remove('d-none');
            dailyBreakdownValuesDiv.classList.remove('d-none');
            
            // Add header
            dailyBreakdownDiv.innerHTML = '<p class="text-muted mb-2">Rincian Harian:</p>';
            dailyBreakdownValuesDiv.innerHTML = '<p class="text-muted mb-2">&nbsp;</p>';
            
            // Add each day's breakdown
            dayPrices.forEach(day => {
                const dateStr = day.date.toLocaleDateString('id-ID', { 
                    day: 'numeric', 
                    month: 'short'
                });
                const dayStr = day.dayName.charAt(0).toUpperCase() + day.dayName.slice(1);
                
                if (day.discountPercentage > 0) {
                    dailyBreakdownDiv.innerHTML += `<p class="small mb-1">${dateStr} (${dayStr}, <span class="text-success">-${day.discountPercentage}%</span>):</p>`;
                    dailyBreakdownValuesDiv.innerHTML += `<p class="small mb-1"><s>Rp ${formatNumber(day.originalPrice)}</s> <span class="text-success">Rp ${formatNumber(day.discountedPrice)}</span></p>`;
                } else {
                    dailyBreakdownDiv.innerHTML += `<p class="small mb-1">${dateStr} (${dayStr}):</p>`;
                    dailyBreakdownValuesDiv.innerHTML += `<p class="small mb-1">Rp ${formatNumber(day.originalPrice)}</p>`;
                }
            });
        } else {
            dailyBreakdownDiv.classList.add('d-none');
            dailyBreakdownValuesDiv.classList.add('d-none');
        }
        
        // Update the subtotal and discount
        document.getElementById('subtotal').textContent = formatNumber(dailyRate * totalDays);
        document.getElementById('discount-amount').textContent = formatNumber(totalDiscount);
        
        // Calculate insurance (10% of subtotal after discount)
        const insurance = Math.round(subtotal * 0.10);
        document.getElementById('insurance').textContent = formatNumber(insurance);
        
        // Calculate total
        const total = subtotal + insurance;
        document.getElementById('total-amount').textContent = formatNumber(total);
        
        // Update hidden field with the actual total value (no formatting)
        document.getElementById('hidden_total_price').value = Math.round(total);
    }
    
    function formatNumber(num) {
        return Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    
    // Set min date for end date to be at least start_date + 1
    startDateInput.addEventListener('change', function() {
        const startDate = new Date(this.value);
        startDate.setDate(startDate.getDate() + 1);
        const minEndDate = startDate.toISOString().split('T')[0];
        endDateInput.min = minEndDate;
        
        // If current end date is less than new min, update it
        if (endDateInput.value && endDateInput.value < minEndDate) {
            endDateInput.value = minEndDate;
        }
        
        updateDateDifference();
    });
    
    // Update calculations when end date changes
    endDateInput.addEventListener('change', updateDateDifference);
    
    // Payment method selection
    paymentMethods.forEach(radio => {
        radio.addEventListener('change', function() {
            // Hide all payment details sections
            paymentDetailSections.forEach(section => {
                section.classList.add('d-none');
            });
            
            // Show the selected payment method details
            const selectedMethod = this.value;
            const detailsSection = document.getElementById(`${selectedMethod}_details`);
            if (detailsSection) {
                detailsSection.classList.remove('d-none');
            }
        });
    });
    
    // Bank selection for transfer method
    const bankSelect = document.getElementById('bank_select');
    if (bankSelect) {
        bankSelect.addEventListener('change', function() {
            // Hide all bank details
            document.querySelectorAll('.bank-details').forEach(detail => {
                detail.classList.add('d-none');
            });
            
            // Show selected bank details
            const selectedBank = this.value;
            if (selectedBank) {
                const bankDetailsDiv = document.getElementById(`${selectedBank}_details`);
                if (bankDetailsDiv) {
                    bankDetailsDiv.classList.remove('d-none');
                }
            }
        });
    }
    
    // Style the payment options for better UI
    document.head.insertAdjacentHTML('beforeend', `
    <style>
        .payment-option {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .payment-option:hover {
            border-color: #adb5bd;
            background-color: #f8f9fa;
        }
        
        .form-check-input:checked + .form-check-label .payment-option {
            border-color: #0d6efd;
            background-color: #e7f0ff;
        }
    </style>
    `);
});
</script>
<?= $this->endSection() ?>
