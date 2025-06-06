<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    /* Import Font dari Google */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

    /* Variabel Warna untuk tema yang modern dan simpel */
    :root {
        --primary-color: #1a9988; /* Hijau Toska yang Elegan */
        --secondary-color: #f7f9fc; /* Abu-abu sangat terang untuk background */
        --text-dark-color: #2c3e50; /* Abu-abu gelap (soft black) */
        --text-light-color: #8492a6; /* Abu-abu untuk sub-teks */
        --card-bg-color: #ffffff;
        --card-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        --card-shadow-hover: 0 8px 25px rgba(0, 0, 0, 0.1);
        --card-border-radius: 12px;
    }

    /* General Styling */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: var(--secondary-color);
        color: var(--text-dark-color);
    }
    
    /* Custom Title Style */
    .page-title {
        font-weight: 700;
        color: var(--text-dark-color);
        position: relative;
        padding-bottom: 15px;
        margin-bottom: 1rem;
    }
    .page-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background-color: var(--primary-color);
        border-radius: 2px;
    }

    /* Gallery Item Styling */
    .gallery-item {
        position: relative;
        border-radius: var(--card-border-radius);
        overflow: hidden;
        box-shadow: var(--card-shadow);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background-color: var(--card-bg-color);
    }

    .gallery-item:hover {
        transform: translateY(-10px);
        box-shadow: var(--card-shadow-hover);
    }

    .gallery-img {
        width: 100%;
        height: 280px;
        object-fit: cover;
        transition: transform 0.4s ease, filter 0.4s ease;
    }
    
    .gallery-item:hover .gallery-img {
        transform: scale(1.05);
        filter: brightness(0.6);
    }

    .gallery-caption {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 20px;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        color: white;
        transform: translateY(100%);
        transition: transform 0.4s ease-in-out;
    }

    .gallery-item:hover .gallery-caption {
        transform: translateY(0);
    }

    .gallery-caption h5 {
        font-weight: 600;
        margin-bottom: 5px;
        font-size: 1.1rem;
    }

    .gallery-caption p {
        font-size: 0.9rem;
        margin-bottom: 0;
        opacity: 0.9;
    }
</style>

<div class="container py-5 mt-4">
    <div class="text-center mb-5">
        <h1 class="display-4 page-title">Galeri Modern Kami</h1>
        <p class="lead text-muted">Lihat lebih dekat armada pilihan, fasilitas premium, dan momen berkesan bersama pelanggan kami.</p>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="gallery-item">
                <img src="<?= base_url('assets/images/cars/car1.png') ?>" alt="Armada Premium" class="gallery-img">
                <div class="gallery-caption">
                    <h5>Kemewahan di Setiap Perjalanan</h5>
                    <p>Rasakan pengalaman berkendara kelas atas dengan armada premium kami.</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="gallery-item">
                <img src="<?= base_url('assets/images/cars/car2.png') ?>" alt="SUV Petualang" class="gallery-img">
                <div class="gallery-caption">
                    <h5>Jelajahi Dunia Tanpa Batas</h5>
                    <p>SUV tangguh siap menemani setiap petualangan Anda di segala medan.</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="gallery-item">
                <img src="<?= base_url('assets/images/cars/car3.png') ?>" alt="Sedan Profesional" class="gallery-img">
                <div class="gallery-caption">
                    <h5>Gaya Profesional, Kinerja Andal</h5>
                    <p>Pilihan sedan elegan untuk perjalanan bisnis maupun keluarga.</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="gallery-item">
                <img src="<?= base_url('assets/images/cars/facility2.png') ?>" alt="Ruang Tunggu Nyaman" class="gallery-img">
                <div class="gallery-caption">
                    <h5>Kenyamanan Sejak Anda Tiba</h5>
                    <p>Fasilitas ruang tunggu eksklusif untuk kenyamanan maksimal Anda.</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="gallery-item">
                <img src="<?= base_url('assets/images/cars/facility1.png') ?>" alt="Area Parkir Aman" class="gallery-img">
                <div class="gallery-caption">
                    <h5>Aman dan Luas untuk Kendaraan Anda</h5>
                    <p>Area parkir yang terjamin keamanannya selama Anda bersama kami.</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="gallery-item">
                <img src="<?= base_url('assets/images/cars/customer1.png') ?>" alt="Momen Pelanggan" class="gallery-img">
                <div class="gallery-caption">
                    <h5>Kisah Perjalanan Pelanggan</h5>
                    <p>Senyum kepuasan adalah prioritas dan penghargaan terbesar bagi kami.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>