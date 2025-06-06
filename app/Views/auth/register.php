<?= $this->extend('layouts/main') ?>
<?php $hideFooter = true; ?>
<?= $this->section('content') ?>
<style>
    .footer-section {
        display: none !important;
    }
</style>
<div class="auth-container">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8"> 
                <div class="auth-card">
                    <div class="auth-card-header text-center">
                        <h3 class="mb-0">Register</h3>
                        <div class="auth-divider">
                            <span></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (session()->has('errors')): ?>
                        
                        <div class="alert alert-danger custom-alert"> 
                            <ul class="mb-0">
                                <?php foreach (session('errors') as $error): ?>
                                <li><?= esc($error) ?></li> 
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                        
                        <form action="<?= site_url('register') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <div class="form-floating">
                                        <input type="text" name="name" id="name" class="form-control custom-input" value="<?= old('name') ?>" placeholder="Full Name" required>
                                        <label for="name">Full Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" name="email" id="email" class="form-control custom-input" value="<?= old('email') ?>" placeholder="Email Address" required>
                                        <label for="email">Email Address</label>
                                    </div>
                                </div>
                            </div>
                                    
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <div class="form-floating">
                                        <input type="password" name="password" id="password" class="form-control custom-input" placeholder="Password" required>
                                        <label for="password">Password</label>
                                    </div>  
                                    
                                    <div class="form-text form-text-custom">Password must be at least 6 characters long.</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="password" name="password_confirm" id="password_confirm" class="form-control custom-input" placeholder="Confirm Password" required>
                                        <label for="password_confirm">Confirm Password</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <div class="form-floating">
                                        <input type="text" name="phone" id="phone" class="form-control custom-input" value="<?= old('phone') ?>" placeholder="Phone Number" required>
                                        <label for="phone">Phone Number</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="license_number" id="license_number" class="form-control custom-input" value="<?= old('license_number') ?>" placeholder="Driver's License Number" required>
                                        <label for="license_number">Driver's License Number</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="form-floating">
                                    <textarea name="address" id="address" class="form-control custom-input" rows="3" style="height: 100px;" placeholder="Address" required><?= old('address') ?></textarea>
                                    <label for="address">Address</label>
                                </div>
                            </div>
                            
                            
                            <div class="mb-4 form-check custom-form-check"> 
                                <input type="checkbox" name="terms" id="terms" class="form-check-input" required>
                                <label for="terms" class="form-check-label">I agree to the <a href="#" class="auth-link">Terms and Conditions</a></label>
                            </div>
                            
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary auth-btn">Register</button>
                            </div>
                        </form>
                        
                        <div class="mt-4 text-center auth-footer-links"> 
                            <p>Already have an account? <a href="<?= site_url('login') ?>" class="auth-link">Login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    body, html {
        font-family: 'Poppins', sans-serif;
    }

    /* Latar belakang utama yang bersih */
    .auth-container {
        background-color: #F7FAFC; /* Latar belakang abu-abu muda */
        min-height: 100vh;
        padding: 50px 0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow-x: hidden;
    }
    
    /* Kartu (card) dengan gaya modern dan bersih */
    .auth-card {
        background: #FFFFFF; /* Latar belakang putih solid */
        border-radius: 12px;
        padding: 35px 40px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); /* Shadow modern */
        border: 1px solid #E2E8F0;
        color: #2D3748; /* Warna teks gelap utama */
        width: 100%;
        transition: box-shadow 0.3s ease-in-out;
    }
    
    .auth-card:hover {
        transform: none; /* Menghilangkan efek 3D hover */
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* Shadow sedikit lebih kuat */
    }
    
    .auth-card-header {
        margin-bottom: 30px;
    }
    
    .auth-card-header h3 {
        color: #1A202C; /* Warna judul biru kehitaman */
        font-weight: 600;
        font-size: 2.1rem;
    }
    
    /* Garis pemisah dengan warna biru solid */
    .auth-divider {
        position: relative;
        text-align: center;
        margin: 20px auto;
        width: 80px;
    }
    
    .auth-divider span {
        display: inline-block;
        width: 100%;
        height: 3px;
        background: #3B82F6; /* Biru solid sebagai aksen utama */
        border-radius: 2px;
    }

    /* Notifikasi/Alert yang disesuaikan */
    .custom-alert {
        padding: 12px 18px;
        border-radius: 8px;
        font-size: 0.9rem;
        margin-bottom: 20px;
        border: 1px solid transparent;
    }
    .custom-alert.alert-danger {
        color: #9B2C2C; /* Merah tua untuk teks */
        background-color: #FED7D7; /* Merah muda untuk latar */
        border-color: #FBB6B6;
    }
    .custom-alert.alert-success {
        color: #2F855A; /* Hijau tua untuk teks */
        background-color: #C6F6D5; /* Hijau muda untuk latar */
        border-color: #9AE6B4;
    }
    .custom-alert ul { /* Gaya untuk list di dalam notifikasi */
        list-style-type: none;
        padding-left: 0;
        margin-bottom: 0;
    }
    .custom-alert ul li {
        margin-bottom: 5px;
    }
    .custom-alert ul li:last-child {
        margin-bottom: 0;
    }
    
    /* Input form yang modern */
    .custom-input {
        border: 1px solid #CBD5E0; /* Border abu-abu */
        border-radius: 8px;
        padding: 15px 10px;
        background: #F8F9FA;
        color: #2D3748;
        transition: all 0.3s ease;
        box-shadow: none !important;
    }
    
    .custom-input::placeholder {
        color: #A0AEC0;
    }

    .custom-input:focus {
        border-color: #3B82F6; /* Border biru saat aktif */
        background: #FFFFFF;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25) !important;
    }

    textarea.custom-input { /* Gaya spesifik untuk textarea */
        min-height: 100px;
        resize: vertical;
        line-height: 1.5;
    }
    
    .form-floating label {
        padding-left: 10px;
        color: #718096; /* Warna label abu-abu */
    }
    
    .form-floating > .form-control:focus ~ label,
    .form-floating > .form-control:not(:placeholder-shown) ~ label {
        color: #3B82F6; /* Warna label biru saat aktif */
    }

    /* Teks bantuan di bawah input */
    .form-text-custom {
        color: #718096; /* Warna abu-abu */
        font-size: 0.8rem;
        margin-top: 5px;
        padding-left: 5px;
    }

    /* Checkbox */
    .custom-form-check .form-check-input {
        background-color: #E2E8F0;
        border: 1px solid #CBD5E0;
        transition: all 0.3s ease;
    }
    
    .custom-form-check .form-check-input:checked {
        background-color: #3B82F6;
        border-color: #3B82F6;
    }

    .custom-form-check .form-check-input:focus {
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
    }

    .custom-form-check .form-check-label {
        color: #4A5568;
    }
    .custom-form-check .form-check-label .auth-link {
        font-weight: 500;
    }
    
    /* Tombol utama */
    .auth-btn {
        padding: 14px;
        font-weight: 600;
        font-size: 1.05rem;
        letter-spacing: 0.8px;
        border-radius: 8px; /* Disesuaikan dengan input */
        background: #3B82F6; /* Biru solid */
        border: none;
        color: #fff;
        transition: all 0.3s ease-out;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .auth-btn:hover {
        transform: translateY(-2px);
        background: #2563EB; /* Biru lebih gelap saat hover */
        box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
    }
    
    /* Link di bagian bawah */
    .auth-footer-links p {
        margin-bottom: 8px;
        color: #718096;
    }

    .auth-link {
        color: #3B82F6; /* Link berwarna biru */
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .auth-link:hover {
        color: #1A202C; /* Link lebih gelap saat hover */
        text-decoration: underline;
    }
    
    /* Penyesuaian untuk layar mobile (dipertahankan dari kode asli) */
    @media (max-width: 768px) {
        .auth-container {
            padding: 30px 0;
            align-items: flex-start;
        }
        .auth-card {
            padding: 25px 20px;
            margin: 15px;
            border: none;
        }
        .auth-card-header h3 {
            font-size: 1.8rem;
        }
        .auth-btn {
            padding: 12px;
            font-size: 1rem;
        }
    }
    
    /* Fix untuk stacking di mobile (dipertahankan dari kode asli) */
    @media (max-width: 767.98px) {
        .row > div[class*="col-md-"].mb-md-0 {
            margin-bottom: 1rem !important;
        }
        .row > div[class*="col-md-"]:last-child {
            margin-bottom: 0 !important;
        }
        .row.mb-4 > div[class*="col-md-"]:last-child.mb-md-0 {
            margin-bottom: 0 !important;
        }
    }

</style>
<?= $this->endSection() ?>