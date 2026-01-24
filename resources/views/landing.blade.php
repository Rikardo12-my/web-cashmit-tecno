<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CashMit - Tarik Tunai COD Aman & Praktis</title>
    <meta name="description" content="Layanan tarik tunai COD dengan sistem QRIS yang aman, cepat, dan terpercaya">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #4A90E2;
            --primary-light: #E8F3FF;
            --primary-dark: #357ABD;
            --secondary: #64C5B1;
            --light: #F8FAFC;
            --dark: #1E293B;
            --gray: #64748B;
            --gray-light: #F1F5F9;
            --success: #10B981;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.12);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--dark);
            line-height: 1.6;
            background-color: #ffffff;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 {
            font-weight: 700;
            color: var(--dark);
        }

        .container {
            max-width: 1200px;
        }

        .section {
            padding: 80px 0;
        }

        .section-sm {
            padding: 60px 0;
        }

        .section-title {
            margin-bottom: 48px;
            text-align: center;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 16px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .section-title p {
            font-size: 1.125rem;
            color: var(--gray);
            max-width: 600px;
            margin: 0 auto;
        }

        /* Navbar */
        .navbar {
            padding: 20px 0;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(74, 144, 226, 0.1);
            transition: var(--transition);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary);
        }

        .navbar-brand img {
            transition: var(--transition);
        }

        .navbar-brand:hover img {
            transform: scale(1.05);
        }

        .nav-link {
            font-weight: 500;
            color: var(--dark) !important;
            padding: 8px 16px !important;
            margin: 0 4px;
            border-radius: var(--radius-sm);
            transition: var(--transition);
        }

        .nav-link:hover {
            background: var(--primary-light);
            color: var(--primary) !important;
        }

        .nav-link.active {
            background: var(--primary-light);
            color: var(--primary) !important;
        }

        .btn {
            padding: 12px 28px;
            border-radius: var(--radius-sm);
            font-weight: 600;
            transition: var(--transition);
            border: none;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary);
            color: var(--primary);
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero-section {
            padding: 120px 0 80px;
            background: linear-gradient(135deg, var(--light) 0%, #ffffff 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 70%;
            height: 140%;
            background: linear-gradient(135deg, rgba(74, 144, 226, 0.05) 0%, rgba(100, 197, 177, 0.03) 100%);
            border-radius: 50%;
            z-index: 0;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-content h1 {
            font-size: 3.25rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 24px;
            color: var(--dark);
        }

        .hero-content h1 span {
            color: var(--primary);
            position: relative;
            display: inline-block;
        }

        .hero-content h1 span::after {
            content: '';
            position: absolute;
            bottom: 8px;
            left: 0;
            width: 100%;
            height: 8px;
            background: rgba(74, 144, 226, 0.2);
            z-index: -1;
            border-radius: 4px;
        }

        .hero-content p {
            font-size: 1.125rem;
            color: var(--gray);
            margin-bottom: 32px;
            max-width: 540px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: rgba(74, 144, 226, 0.1);
            border-radius: 50px;
            color: var(--primary);
            font-weight: 500;
            margin-bottom: 24px;
        }

        .hero-badge i {
            font-size: 0.875rem;
        }

        .hero-image {
            position: relative;
            z-index: 1;
        }

        .hero-image-container {
            position: relative;
            max-width: 500px;
            margin: 0 auto;
        }

        .hero-image-main {
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            transform: perspective(1000px) rotateY(-10deg);
            transition: var(--transition);
        }

        .hero-image-main:hover {
            transform: perspective(1000px) rotateY(0deg);
        }

        .hero-image-main img {
            width: 100%;
            height: auto;
            display: block;
        }

        .floating-element {
            position: absolute;
            padding: 16px;
            background: white;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-lg);
            display: flex;
            align-items: center;
            gap: 12px;
            animation: float 6s ease-in-out infinite;
        }

        .floating-element.success {
            top: 20%;
            left: -20px;
            border-left: 4px solid var(--success);
        }

        .floating-element.warning {
            bottom: 20%;
            right: -20px;
            border-left: 4px solid #F59E0B;
        }

        .floating-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-shrink: 0;
        }

        .floating-element.success .floating-icon {
            background: var(--success);
        }

        .floating-element.warning .floating-icon {
            background: #F59E0B;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        /* Features */
        .feature-card {
            background: white;
            padding: 32px;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(74, 144, 226, 0.1);
            transition: var(--transition);
            height: 100%;
            text-align: center;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary-light);
        }

        .feature-icon {
            width: 64px;
            height: 64px;
            background: var(--primary-light);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            transition: var(--transition);
        }

        .feature-card:hover .feature-icon {
            background: var(--primary);
            transform: scale(1.1);
        }

        .feature-icon i {
            font-size: 1.5rem;
            color: var(--primary);
            transition: var(--transition);
        }

        .feature-card:hover .feature-icon i {
            color: white;
        }

        .feature-card h4 {
            font-size: 1.25rem;
            margin-bottom: 12px;
            color: var(--dark);
        }

        .feature-card p {
            color: var(--gray);
            margin-bottom: 0;
        }

        /* How It Works */
        .how-it-works {
            background: var(--light);
        }

        .step-card {
            background: white;
            padding: 32px;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            position: relative;
            height: 100%;
            border: 1px solid rgba(74, 144, 226, 0.1);
        }

        .step-number {
            position: absolute;
            top: -20px;
            left: 32px;
            width: 40px;
            height: 40px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.125rem;
            box-shadow: var(--shadow-md);
        }

        .step-icon {
            width: 48px;
            height: 48px;
            background: var(--primary-light);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .step-icon i {
            font-size: 1.25rem;
            color: var(--primary);
        }

        .step-card h5 {
            font-size: 1.125rem;
            margin-bottom: 12px;
            color: var(--dark);
        }

        .step-card p {
            color: var(--gray);
            margin-bottom: 0;
        }

        /* Stats */
        .stats-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
        }

        .stat-item {
            text-align: center;
            padding: 20px;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: white;
        }

        .stat-label {
            font-size: 1rem;
            opacity: 0.9;
            color: rgba(255, 255, 255, 0.9);
        }

        /* Testimonials */
        .testimonial-card {
            background: white;
            padding: 32px;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(74, 144, 226, 0.1);
            height: 100%;
        }

        .testimonial-content {
            position: relative;
            margin-bottom: 24px;
        }

        .testimonial-content p {
            color: var(--gray);
            font-style: italic;
            margin-bottom: 0;
        }

        .testimonial-content::before {
            content: '"';
            position: absolute;
            top: -20px;
            left: -10px;
            font-size: 4rem;
            color: var(--primary-light);
            font-family: Georgia, serif;
            opacity: 0.3;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .author-avatar {
            width: 48px;
            height: 48px;
            background: var(--primary-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-weight: 600;
            flex-shrink: 0;
        }

        .author-info h6 {
            margin-bottom: 4px;
            color: var(--dark);
        }

        .author-info small {
            color: var(--gray);
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--light) 0%, #ffffff 100%);
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 300px;
            height: 300px;
            background: rgba(74, 144, 226, 0.05);
            border-radius: 50%;
        }

        .cta-section::after {
            content: '';
            position: absolute;
            bottom: -100px;
            left: -100px;
            width: 300px;
            height: 300px;
            background: rgba(100, 197, 177, 0.05);
            border-radius: 50%;
        }

        .cta-card {
            background: white;
            padding: 48px;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .cta-card h2 {
            font-size: 2.25rem;
            margin-bottom: 16px;
            color: var(--dark);
        }

        .cta-card p {
            font-size: 1.125rem;
            color: var(--gray);
            margin-bottom: 32px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Footer */
        .footer {
            background: var(--dark);
            color: white;
            padding: 64px 0 32px;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
        }

        .footer-logo:hover {
            color: white;
        }

        .footer-logo img {
            filter: brightness(0) invert(1);
        }

        .footer-about p {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 24px;
        }

        .footer-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: white;
            margin-bottom: 20px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: var(--transition);
            display: inline-block;
        }

        .footer-links a:hover {
            color: white;
            transform: translateX(4px);
        }

        .footer-contact {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-contact li {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 16px;
            color: rgba(255, 255, 255, 0.7);
        }

        .footer-contact i {
            color: var(--primary);
            margin-top: 4px;
        }

        .social-links {
            display: flex;
            gap: 16px;
            margin-top: 24px;
        }

        .social-link {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: var(--transition);
        }

        .social-link:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }

        .footer-bottom {
            padding-top: 32px;
            margin-top: 48px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            color: rgba(255, 255, 255, 0.5);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .section {
                padding: 60px 0;
            }
            
            .section-title h2 {
                font-size: 2rem;
            }
            
            .hero-content h1 {
                font-size: 2.5rem;
            }
            
            .hero-section {
                padding: 100px 0 60px;
            }
            
            .cta-card {
                padding: 32px 24px;
            }
            
            .floating-element {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .hero-content h1 {
                font-size: 2rem;
            }
            
            .btn {
                width: 100%;
                margin-bottom: 12px;
            }
            
            .d-flex.gap-3 {
                flex-direction: column;
            }
        }

        /* Utilities */
        .text-primary {
            color: var(--primary) !important;
        }

        .bg-primary-light {
            background: var(--primary-light) !important;
        }

        .border-primary-light {
            border-color: rgba(74, 144, 226, 0.2) !important;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#home">
                <img src="{{ asset('adminlte/dist/img/LogoCashMit.png') }}" alt="CashMit Logo" height="40" width="40">
                CashMit
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#how-it-works">Cara Kerja</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">Testimoni</a>
                    </li>
                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                        <a class="btn btn-primary" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-2"></i>Masuk
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <div class="hero-badge">
                            <i class="fas fa-bolt"></i>
                            <span>Tarik Tunai COD dengan QRIS</span>
                        </div>
                        <h1>Uang Tunai <span>Di Antarkan</span> Ke Lokasi Anda</h1>
                        <p>CashMit menghadirkan solusi tarik tunai modern dengan sistem COD dan pembayaran QRIS. Aman, cepat, dan praktis tanpa perlu keluar rumah.</p>
                        <div class="d-flex gap-3 flex-wrap">
                            <a href="{{ route('register') }}" class="btn btn-primary">
                                <i class="fas fa-rocket me-2"></i>Mulai Sekarang
                            </a>
                            <a href="#how-it-works" class="btn btn-outline-primary">
                                <i class="fas fa-play-circle me-2"></i>Lihat Demo
                            </a>
                        </div>
                        <div class="mt-4">
                            <div class="row g-3">
                                <div class="col-auto">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-shield-alt text-primary"></i>
                                        <small class="text-muted">100% Aman</small>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-bolt text-primary"></i>
                                        <small class="text-muted">Proses Cepat</small>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-headset text-primary"></i>
                                        <small class="text-muted">24/7 Support</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0">
                    <div class="hero-image-container">
                        <div class="hero-image-main">
                            <img src="https://images.unsplash.com/photo-1563013544-824ae1b704d3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="CashMit Mobile App">
                        </div>
                        <div class="floating-element success">
                            <div class="floating-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">10K+ Transaksi</h6>
                                <small class="text-muted">Berhasil Diproses</small>
                            </div>
                        </div>
                        <div class="floating-element warning">
                            <div class="floating-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">5 Menit</h6>
                                <small class="text-muted">Rata-rata Waktu</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="section">
        <div class="container">
            <div class="section-title">
                <h2>Keunggulan CashMit</h2>
                <p>Solusi terbaik untuk kebutuhan tarik tunai Anda dengan berbagai keunggulan</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h4>Keamanan Terjamin</h4>
                        <p>Sistem keamanan berlapis dengan enkripsi end-to-end dan verifikasi multi-level untuk setiap transaksi.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-qrcode"></i>
                        </div>
                        <h4>QRIS</h4>
                        <p>Proses pembayaran yang cepat dan mudah dengan sistem QRIS.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4>Fleksibel Lokasi</h4>
                        <p>Tentukan lokasi COD sesuai keinginan Anda di sekitar kampus 1 Universitas Methodist Indonesia.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="section how-it-works">
        <div class="container">
            <div class="section-title">
                <h2>Cara Kerja CashMit</h2>
                <p>Hanya 4 langkah mudah untuk mendapatkan uang tunai di lokasi Anda</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="step-card">
                        <div class="step-number">1</div>
                        <div class="step-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <h5>Daftar Akun</h5>
                        <p>Buat akun CashMit dan lengkapi verifikasi identitas Anda dalam hitungan menit.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="step-card">
                        <div class="step-number">2</div>
                        <div class="step-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <h5>Pilih Jumlah</h5>
                        <p>Tentukan jumlah uang tunai yang ingin ditarik dan pilih metode QRIS COD.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="step-card">
                        <div class="step-number">3</div>
                        <div class="step-icon">
                            <i class="fas fa-location-dot"></i>
                        </div>
                        <h5>Tentukan Lokasi</h5>
                        <p>Pilih lokasi penyerahan COD dan waktu yang sesuai dengan kebutuhan Anda.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="step-card">
                        <div class="step-number">4</div>
                        <div class="step-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h5>Terima Uang Tunai</h5>
                        <p>Petugas kami akan mengantarkan uang tunai ke lokasi yang telah Anda tentukan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="section-sm stats-section">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-item">
                        <div class="stat-number">10.000+</div>
                        <div class="stat-label">Pengguna Aktif</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-item">
                        <div class="stat-number">50.000+</div>
                        <div class="stat-label">Transaksi</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-item">
                        <div class="stat-number">99,8%</div>
                        <div class="stat-label">Kepuasan Pengguna</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-item">
                        <div class="stat-number">5 Menit</div>
                        <div class="stat-label">Proses Rata-rata</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section id="testimonials" class="section">
        <div class="container">
            <div class="section-title">
                <h2>Apa Kata Pengguna</h2>
                <p>Testimoni dari pengguna setia CashMit</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <p>"Sangat membantu saat butuh uang tunai mendadak. Proses cepat dan petugas ramah."</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">RP</div>
                            <div class="author-info">
                                <h6>Ronny Pandiangan</h6>
                                <small>Mahasiswa FIKOM UMI</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <p>"QRIS COD-nya praktis banget, tidak perlu keluar rumah. Pelayanan sangat memuaskan."</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">HH</div>
                            <div class="author-info">
                                <h6>Hilman Hutahaean</h6>
                                <small>Mahasiswa FIKOM UMI</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <p>"Keamanan transaksi terjamin dengan verifikasi berlapis. Recommended untuk semua orang!"</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">JM</div>
                            <div class="author-info">
                                <h6>Jetli Manik</h6>
                                <small>Mahasiswa FIKOM UMI</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section cta-section">
        <div class="container">
            <div class="cta-card">
                <h2>Siap Mulai Menggunakan CashMit?</h2>
                <p>Bergabunglah dengan komunitas pengguna CashMit dan nikmati kemudahan tarik tunai COD dengan sistem QRIS yang aman dan terpercaya.</p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-sign-in-alt me-2"></i>Masuk Akun
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <a href="#home" class="footer-logo">
                        CashMit
                    </a>
                    <div class="footer-about">
                        <p>Layanan tarik tunai COD dengan sistem QRIS yang aman, cepat, dan terpercaya. Hadir untuk memudahkan kebutuhan finansial Anda.</p>
                        <div class="social-links">
                            <a href="#" class="social-link">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h6 class="footer-title">Menu</h6>
                    <ul class="footer-links">
                        <li><a href="#home">Beranda</a></li>
                        <li><a href="#features">Fitur</a></li>
                        <li><a href="#how-it-works">Cara Kerja</a></li>
                        <li><a href="#testimonials">Testimoni</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h6 class="footer-title">Layanan</h6>
                    <ul class="footer-links">
                        <li><a href="#">Tarik Tunai COD</a></li>
                        <li><a href="#">QRIS Payment</a></li>
                        <li><a href="#">Lokasi COD</a></li>
                        <li><a href="#">Tracking Order</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <h6 class="footer-title">Hubungi Kami</h6>
                    <ul class="footer-contact">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <strong>Alamat</strong>
                                <div>Jl. Hang Tuah No. 8, Madras Hulu, Kec. Medan Polonia, Kota Medan, Sumatera Utara</div>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            <div>
                                <strong>Telepon</strong>
                                <div>0838-5115-3060</div>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <div>
                                <strong>Email</strong>
                                <div>cashmitumi@gmail.com</div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p>&copy; 2024 CashMit. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <a href="#" class="text-decoration-none me-3" style="color: rgba(255, 255, 255, 0.5);">Privacy Policy</a>
                        <a href="#" class="text-decoration-none" style="color: rgba(255, 255, 255, 0.5);">Terms of Service</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.08)';
                navbar.style.padding = '12px 0';
            } else {
                navbar.style.boxShadow = '0 2px 8px rgba(0, 0, 0, 0.04)';
                navbar.style.padding = '20px 0';
            }
        });

        // Active nav link on scroll
        const sections = document.querySelectorAll('section[id]');
        window.addEventListener('scroll', function() {
            const scrollPosition = window.scrollY + 100;
            
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.offsetHeight;
                const sectionId = section.getAttribute('id');
                
                if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                    document.querySelectorAll('.nav-link').forEach(link => {
                        link.classList.remove('active');
                        if (link.getAttribute('href') === `#${sectionId}`) {
                            link.classList.add('active');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>