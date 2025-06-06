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
            <div class="col-md-6">
                <div class="auth-card">
                    <div class="auth-card-header text-center">
                        <h3 class="mb-0">Forgot Password</h3>
                        <div class="auth-divider">
                            <span></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-center mb-4">Enter your email address and we will send you a link to reset your password.</p>
                        
                        <?php if (session()->has('error')): ?>
                        <div class="alert alert-danger custom-alert">
                            <?= session('error') ?>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (session()->has('success')): ?>
                        <div class="alert alert-success custom-alert">
                            <?= session('success') ?>
                        </div>
                        <?php endif; ?>
                        
                        <form action="<?= site_url('forgot-password') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="mb-4">
                                <div class="form-floating">
                                    <input type="email" name="email" id="email" class="form-control custom-input" value="<?= old('email') ?>" placeholder="Email Address" required>
                                    <label for="email">Email Address</label>
                                </div>
                            </div>
                            
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary auth-btn">Send Reset Link</button>
                            </div>
                        </form>
                        
                        <div class="mt-4 text-center auth-links-footer">
                            <p>Remember your password? <a href="<?= site_url('login') ?>" class="auth-link">Back to Login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Mengimpor Font Poppins yang sudah ada */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    body, html {
        font-family: 'Poppins', sans-serif;
    }

    /* Latar belakang utama yang sesuai dengan area konten di gambar */
    .auth-container {
        background-color: #F7FAFC; /* Warna abu-abu sangat muda */
        min-height: 100vh;
        padding: 50px 0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow-x: hidden;
    }
    
    /* Kartu login dengan gaya yang bersih dan modern */
    .auth-card {
        background: #FFFFFF; /* Latar belakang putih solid */
        border-radius: 12px; /* Sudut yang sedikit membulat */
        padding: 40px 40px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); /* Shadow yang lembut */
        border: 1px solid #E2E8F0; /* Border abu-abu muda */
        color: #2D3748; /* Warna teks utama gelap */
        transition: box-shadow 0.3s ease-in-out;
    }
    
    .auth-card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* Shadow sedikit lebih kuat saat hover */
    }
    
    .auth-card-header {
        margin-bottom: 30px;
    }
    
    /* Judul header */
    .auth-card-header h3 {
        color: #1A202C; /* Warna biru-kehitaman untuk judul */
        font-weight: 600; /* Sedikit lebih tipis dari 700 agar lebih modern */
        font-size: 1.9rem;
    }
    
    /* Garis pemisah dengan warna biru utama */
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
        background: #3B82F6; /* Warna biru solid seperti di header gambar */
        border-radius: 2px;
    }

    /* Notifikasi (Alert) dengan gaya yang sesuai */
    .custom-alert {
        border-radius: 8px;
        padding: 12px 18px;
        font-size: 0.9rem;
        border: 1px solid transparent;
    }
    .custom-alert.alert-danger {
        color: #9B2C2C;
        background-color: #FED7D7;
        border-color: #FBB6B6;
    }
   .custom-alert.alert-success {
        color: #2F855A;
        background-color: #C6F6D5;
        border-color: #9AE6B4;
    }
    
    /* Input form yang modern */
    .custom-input {
        border: 1px solid #CBD5E0; /* Border abu-abu */
        border-radius: 8px; /* Sudut membulat */
        padding: 15px;
        background: #F8F9FA; /* Latar belakang input sedikit abu-abu */
        color: #2D3748; /* Warna teks gelap */
        transition: all 0.3s ease;
        box-shadow: none !important;
    }
    
    .custom-input::placeholder {
        color: #A0AEC0; /* Warna placeholder */
    }

    .custom-input:focus {
        border-color: #3B82F6; /* Border biru saat aktif */
        background: #FFFFFF;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25) !important; /* Efek glow biru */
    }
    
    /* Label untuk floating input */
    .form-floating label {
        padding-left: 10px;
        color: #718096; /* Warna abu-abu untuk label */
    }
    
    .form-floating > .form-control:focus ~ label,
    .form-floating > .form-control:not(:placeholder-shown) ~ label {
        color: #3B82F6; /* Warna label menjadi biru saat aktif */
    }
    
    /* Tombol Login utama */
    .auth-btn {
        padding: 14px;
        font-weight: 600;
        font-size: 1.05rem;
        border-radius: 8px; /* Sudut disamakan dengan input */
        background: #3B82F6; /* Warna biru utama */
        border: none;
        color: #fff;
        transition: all 0.3s ease-out;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .auth-btn:hover {
        background: #2563EB; /* Biru sedikit lebih gelap saat hover */
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3); /* Shadow biru */
    }
    
    /* Link di bagian bawah */
    .auth-links-footer p {
        color: #718096;
    }

    .auth-link {
        color: #3B82F6; /* Link berwarna biru */
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .auth-link:hover {
        color: #1A202C; /* Link menjadi lebih gelap saat hover */
        text-decoration: underline;
    }
    
    /* Penyesuaian untuk layar mobile */
    @media (max-width: 768px) {
        .auth-card {
            padding: 25px 20px;
            margin: 0 15px;
            border: none; /* Hilangkan border di mobile agar lebih bersih */
        }
        .auth-card-header h3 {
            font-size: 1.8rem;
        }
    }
</style>
<?= $this->endSection() ?> 