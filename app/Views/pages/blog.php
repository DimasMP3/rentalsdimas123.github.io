<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    /* Blog Page Styles */
    .blog-section {
        padding: 80px 0;
    }
    
    .blog-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 30px;
        overflow: hidden;
    }
    
    .blog-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
    }
    
    .blog-card img {
        height: 220px;
        object-fit: cover;
        width: 100%;
    }
    
    .blog-card .card-body {
        padding: 25px;
    }
    
    .blog-date {
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 10px;
        display: block;
    }
    
    .blog-title {
        font-weight: 600;
        font-size: 1.3rem;
        margin-bottom: 12px;
        color: #343a40;
        line-height: 1.4;
    }
    
    .blog-excerpt {
        color: #6c757d;
        margin-bottom: 18px;
        font-size: 0.95rem;
        line-height: 1.6;
    }
    
    .btn-read-more {
        color: var(--primary-color);
        font-weight: 600;
        padding: 8px 0;
        position: relative;
        display: inline-block;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .btn-read-more::after {
        content: '';
        position: absolute;
        bottom: 5px;
        left: 0;
        width: 0;
        height: 2px;
        background-color: var(--primary-color);
        transition: width 0.3s ease;
    }
    
    .btn-read-more:hover::after {
        width: 100%;
    }
    
    .blog-sidebar {
        background-color: #f8f9fa;
        padding: 25px;
        border-radius: 15px;
    }
    
    .sidebar-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e9ecef;
    }
    
    .sidebar-categories li {
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }
    
    .sidebar-categories li:hover {
        padding-left: 5px;
    }
    
    .sidebar-categories a {
        color: #6c757d;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .sidebar-categories a:hover {
        color: var(--primary-color);
    }
    
    /* Responsive Styles */
    @media (max-width: 767.98px) {
        .blog-section {
            padding: 50px 0;
        }
        
        .blog-sidebar {
            margin-top: 40px;
        }
    }
</style>

<div class="container blog-section">
    <div class="row">
        <div class="col-lg-8">
            <div class="mb-5">
                <h1 class="display-5 mb-3">Blog</h1>
                <p class="lead text-muted">Temukan tips dan panduan terbaru seputar rental mobil dari kami.</p>
            </div>
            
            <div class="row">
                <?php foreach ($posts as $post): ?>
                <div class="col-md-6">
                    <div class="blog-card card h-100">
                        <img src="<?= base_url($post['image']) ?>" class="card-img-top" alt="<?= $post['title'] ?>">
                        <div class="card-body d-flex flex-column">
                            <span class="blog-date"><i class="far fa-calendar-alt me-2"></i><?= date('d M Y', strtotime($post['date'])) ?></span>
                            <h5 class="blog-title"><?= $post['title'] ?></h5>
                            <p class="blog-excerpt"><?= $post['excerpt'] ?></p>
                            <a href="<?= site_url('blog/post/' . $post['id']) ?>" class="btn-read-more mt-auto">Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <nav class="mt-5">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
        
        <div class="col-lg-4">
            <div class="blog-sidebar">
                <h4 class="sidebar-title">Categories</h4>
                <ul class="sidebar-categories list-unstyled">
                    <li><a href="#"><i class="fas fa-angle-right me-2"></i>Tips Rental Mobil</a></li>
                    <li><a href="#"><i class="fas fa-angle-right me-2"></i>Panduan Perjalanan</a></li>
                    <li><a href="#"><i class="fas fa-angle-right me-2"></i>Perawatan Mobil</a></li>
                    <li><a href="#"><i class="fas fa-angle-right me-2"></i>Destinasi Wisata</a></li>
                    <li><a href="#"><i class="fas fa-angle-right me-2"></i>Ulasan Mobil</a></li>
                </ul>
                
                <h4 class="sidebar-title mt-4">Recent Posts</h4>
                <div class="recent-post mb-3">
                    <a href="#" class="d-flex align-items-center text-decoration-none">
                        <img src="<?= base_url('/assets/images/cars/blog-1.png') ?>" alt="Recent Post" width="70" height="70" class="rounded me-3">
                        <div>
                            <h6 class="mb-1 text-dark">Tips Memilih Mobil Rental yang Tepat</h6>
                            <small class="text-muted">15 Jun 2023</small>
                        </div>
                    </a>
                </div>
                <div class="recent-post mb-3">
                    <a href="#" class="d-flex align-items-center text-decoration-none">
                        <img src="<?= base_url('assets/images/cars/blog-2.png') ?>" alt="Recent Post" width="70" height="70" class="rounded me-3">
                        <div>
                            <h6 class="mb-1 text-dark">Panduan Lengkap Menyewa Mobil untuk Liburan</h6>
                            <small class="text-muted">20 Jul 2023</small>
                        </div>
                    </a>
                </div>
                
                <h4 class="sidebar-title mt-4">Tags</h4>
                <div class="d-flex flex-wrap gap-2">
                    <a href="#" class="badge bg-light text-dark text-decoration-none p-2">Rental</a>
                    <a href="#" class="badge bg-light text-dark text-decoration-none p-2">Mobil</a>
                    <a href="#" class="badge bg-light text-dark text-decoration-none p-2">Perjalanan</a>
                    <a href="#" class="badge bg-light text-dark text-decoration-none p-2">Tips</a>
                    <a href="#" class="badge bg-light text-dark text-decoration-none p-2">Liburan</a>
                    <a href="#" class="badge bg-light text-dark text-decoration-none p-2">Wisata</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?> 