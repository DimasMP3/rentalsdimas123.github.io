<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    /* Import Font dari Google */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Lato:wght@400;700&display=swap');

    /* Variabel Warna untuk kemudahan kustomisasi */
    :root {
        --primary-color: #007bff;
        --secondary-color: #6c757d;
        --light-gray-color: #f8f9fa;
        --dark-text-color: #343a40;
        --light-text-color: #6c757d;
        --card-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        --card-border-radius: 15px;
    }

    /* Tipografi Dasar */
    body {
        font-family: 'Lato', sans-serif;
        color: var(--dark-text-color);
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
    }

    .section-title {
        font-weight: 700;
        color: var(--dark-text-color);
        margin-bottom: 2.5rem; /* 40px */
    }

    /* Kustomisasi Card */
    .card {
        border: none;
        border-radius: var(--card-border-radius);
        box-shadow: var(--card-shadow);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
    }
    
    .card-title {
        color: var(--primary-color);
    }

    .card-text.text-muted {
        color: var(--light-text-color) !important;
        font-size: 0.9rem;
    }

    /* Kustomisasi Bagian Tim */
    .team-card img {
        border-top-left-radius: var(--card-border-radius);
        border-top-right-radius: var(--card-border-radius);
    }

    /* Kustomisasi Bagian Misi & Nilai */
    .value-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        background-color: rgba(0, 123, 255, 0.1);
        color: var(--primary-color);
        border-radius: 50%;
        font-size: 2rem; /* Ukuran ikon diperbesar */
        margin-bottom: 1rem;
    }

    /* Kustomisasi Bagian 'Mengapa Memilih Kami' */
    .feature-item .feature-icon {
        font-size: 1.8rem;
        color: var(--primary-color);
    }

    .img-fluid {
        border-radius: var(--card-border-radius);
    }

</style>

<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4">Tentang Kami</h1>
        <p class="lead text-muted">Mengenal lebih dekat perjalanan, misi, dan tim di balik layanan kami.</p>
    </div>

    <div class="row align-items-center mb-5 pb-4">
        <div class="col-lg-6 mb-4">
            <img src="<?= base_url('assets/images/about-us.png') ?>" alt="Tentang CarRent" class="img-fluid shadow-lg">
        </div>
        <div class="col-lg-6 mb-4">
            <h2>Kisah Kami</h2>
            <p class="text-muted">RentaldotSkuy didirikan pada tahun 2025 dengan misi sederhana: menyediakan layanan sewa mobil berkualitas tinggi dengan harga terjangkau. Yang dimulai sebagai armada kecil dengan hanya 5 mobil, kini telah berkembang menjadi layanan persewaan komprehensif dengan lebih dari 100 kendaraan dari berbagai merek dan model.</p>
            <p class="text-muted">Pendiri kami, Dimas Maulana Putra, menyadari adanya kebutuhan akan layanan sewa mobil yang andal dan mengutamakan kepuasan pelanggan di atas segalanya. Visi ini terus menjadi panduan operasional kami hingga hari ini.</p>
        </div>
    </div>

    <div class="bg-light rounded p-5 mb-5">
        <div class="col-12">
            <h2 class="text-center section-title">Misi & Nilai Kami</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <div class="card-body p-4">
                            <div class="value-icon"><i class="fas fa-handshake"></i></div>
                            <h5 class="card-title">Pelanggan Utama</h5>
                            <p class="card-text">Kami memprioritaskan kepuasan pelanggan dalam setiap aspek layanan kami, memastikan pengalaman sewa yang lancar dari awal hingga akhir.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <div class="card-body p-4">
                            <div class="value-icon"><i class="fas fa-shield-alt"></i></div>
                            <h5 class="card-title">Keamanan & Keandalan</h5>
                            <p class="card-text">Semua kendaraan kami menjalani pemeriksaan perawatan yang ketat untuk memastikan keamanan dan keandalannya bagi pelanggan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <div class="card-body p-4">
                            <div class="value-icon"><i class="fas fa-leaf"></i></div>
                            <h5 class="card-title">Tanggung Jawab Lingkungan</h5>
                            <p class="card-text">Kami berkomitmen untuk mengurangi jejak lingkungan dengan memelihara kendaraan hemat bahan bakar dan menerapkan praktik berkelanjutan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5 pb-4">
        <div class="col-12">
            <h2 class="text-center section-title">Tim Profesional Kami</h2>
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card text-center team-card">
                        <img src="<?= base_url('assets/images/team-1.png') ?>" class="card-img-top" alt="Anggota Tim">
                        <div class="card-body">
                            <h5 class="card-title mb-0">Dimas Maulana Putra</h5>
                            <p class="card-text text-muted">Pendiri & CEO</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card text-center team-card">
                        <img src="<?= base_url('assets/images/team-3.png') ?>" class="card-img-top" alt="Anggota Tim">
                        <div class="card-body">
                            <h5 class="card-title mb-0">Haidar Aslam</h5>
                            <p class="card-text text-muted">Manajer Operasional</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card text-center team-card">
                        <img src="<?= base_url('assets/images/team-2.png') ?>" class="card-img-top" alt="Anggota Tim">
                        <div class="card-body">
                            <h5 class="card-title mb-0">Riefaldi Diofano Saputra</h5>
                            <p class="card-text text-muted">Manajer Armada</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card text-center team-card">
                        <img src="<?= base_url('assets/images/team-4.png') ?>" class="card-img-top" alt="Anggota Tim">
                        <div class="card-body">
                            <h5 class="card-title mb-0">Indry Anggraeni</h5>
                            <p class="card-text text-muted">Kepala Layanan Pelanggan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h2 class="text-center section-title">Mengapa Memilih Kami</h2>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="d-flex align-items-start feature-item">
                        <div class="flex-shrink-0 me-3">
                            <i class="fas fa-check-circle feature-icon"></i>
                        </div>
                        <div>
                            <h5>Pilihan Kendaraan Beragam</h5>
                            <p class="text-muted">Dari mobil ekonomis hingga kendaraan mewah, kami memiliki armada yang beragam untuk memenuhi kebutuhan dan preferensi spesifik Anda.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="d-flex align-items-start feature-item">
                        <div class="flex-shrink-0 me-3">
                            <i class="fas fa-check-circle feature-icon"></i>
                        </div>
                        <div>
                            <h5>Harga Kompetitif</h5>
                            <p class="text-muted">Kami menawarkan tarif terbaik di pasar tanpa biaya atau ongkos tersembunyi, memastikan transparansi dalam penetapan harga kami.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="d-flex align-items-start feature-item">
                        <div class="flex-shrink-0 me-3">
                            <i class="fas fa-check-circle feature-icon"></i>
                        </div>
                        <div>
                            <h5>Opsi Sewa Fleksibel</h5>
                            <p class="text-muted">Baik Anda membutuhkan mobil untuk sehari, seminggu, atau sebulan, kami memiliki opsi sewa yang fleksibel untuk mengakomodasi jadwal Anda.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="d-flex align-items-start feature-item">
                        <div class="flex-shrink-0 me-3">
                            <i class="fas fa-check-circle feature-icon"></i>
                        </div>
                        <div>
                            <h5>Dukungan Pelanggan 24/7</h5>
                            <p class="text-muted">Tim layanan pelanggan kami yang berdedikasi tersedia sepanjang waktu untuk membantu Anda dengan pertanyaan atau masalah apa pun.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>