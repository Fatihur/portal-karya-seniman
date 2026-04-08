<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portal Karya Seniman Sumbawa Besar')</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --sumbawa-red: #A83232;
            --sumbawa-dark-red: #7A2424;
            --sumbawa-gold: #D4A574;
            --sumbawa-light-gold: #E8C9A0;
            --sumbawa-cream: #F9F5EB;
            --sumbawa-dark: #2C1810;
        }
        
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: var(--sumbawa-cream);
            min-height: 100vh;
            color: var(--sumbawa-dark);
            transition: padding-top 0.3s ease;
        }
        
        /* Modern Header with Texture */
        .modern-header {
            background: linear-gradient(135deg, var(--sumbawa-red) 0%, var(--sumbawa-dark-red) 100%);
            padding: 0;
            box-shadow: 0 4px 20px rgba(168, 50, 50, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .modern-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M50 0L60 40L100 50L60 60L50 100L40 60L0 50L40 40Z' fill='rgba(255,255,255,0.03)'/%3E%3C/svg%3E");
            background-size: 80px 80px;
            opacity: 0.5;
        }
        
        .header-top {
            padding: 15px 0;
            position: relative;
            z-index: 1000;
        }
        
        .brand-text {
            color: white;
        }
        
        .brand-text h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            letter-spacing: 2px;
        }
        
        .brand-text span {
            color: var(--sumbawa-light-gold);
            font-size: 0.85rem;
            letter-spacing: 3px;
            text-transform: uppercase;
        }
        
        /* Modern Navbar Fixed */
        .modern-navbar {
            background: rgba(0,0,0,0.15);
            padding: 0;
            position: relative;
            z-index: 100;
            transition: all 0.3s ease;
        }

        .modern-navbar.fixed {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(168, 50, 50, 0.98);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100%);
            }
            to {
                transform: translateY(0);
            }
        }
        
        .navbar-nav .nav-link {
            color: white !important;
            padding: 15px 20px !important;
            font-weight: 500;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            border-bottom: 3px solid transparent;
        }
        
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            background: rgba(255,255,255,0.1);
            border-bottom-color: var(--sumbawa-gold);
        }
        
        .search-modern {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 30px;
            padding: 8px 20px;
            color: white;
            width: 250px;
            transition: all 0.3s ease;
        }
        
        .search-modern::placeholder {
            color: rgba(255,255,255,0.7);
        }
        
        .search-modern:focus {
            background: rgba(255,255,255,0.25);
            outline: none;
            border-color: var(--sumbawa-gold);
            box-shadow: 0 0 15px rgba(212, 165, 116, 0.3);
        }
        
        /* User Dropdown - Force above all elements */
        .dropdown-user-menu {
            position: static !important;
        }
        
        .dropdown-user-menu .dropdown-menu-user {
            position: fixed !important;
            top: 80px !important;
            right: 20px !important;
            left: auto !important;
            bottom: auto !important;
            transform: none !important;
            z-index: 99999 !important;
            margin: 0 !important;
        }
        
        /* Hero Section Modern */
        .hero-modern {
            background: linear-gradient(135deg, rgba(168, 50, 50, 0.85) 0%, rgba(44, 24, 16, 0.9) 100%),
                        url("{{ asset('istana-dalam-loka.jpg') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            padding: 120px 0 140px;
            position: relative;
            overflow: hidden;
        }
        
        .hero-modern::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: linear-gradient(to top, var(--sumbawa-cream), transparent);
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
        
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 700;
            color: white;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.3);
            margin-bottom: 25px;
            line-height: 1.2;
        }
        
        .hero-subtitle {
            color: var(--sumbawa-light-gold);
            font-size: 1.3rem;
            margin-bottom: 40px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .btn-hero {
            background: linear-gradient(135deg, var(--sumbawa-gold) 0%, var(--sumbawa-light-gold) 100%);
            color: var(--sumbawa-dark);
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(212, 165, 116, 0.4);
        }
        
        .btn-hero:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(212, 165, 116, 0.5);
            color: var(--sumbawa-dark);
        }
        
        /* Modern Cards */
        .modern-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            transition: all 0.4s ease;
            border: none;
        }
        
        .modern-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(168, 50, 50, 0.15);
        }
        
        .modern-card .card-img-wrapper {
            height: 220px;
            overflow: hidden;
            position: relative;
        }
        
        .modern-card .card-img-wrapper::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: linear-gradient(to top, rgba(0,0,0,0.3), transparent);
        }
        
        .modern-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .modern-card:hover img {
            transform: scale(1.1);
        }
        
        .modern-card .card-body {
            padding: 25px;
        }
        
        .card-category {
            display: inline-block;
            background: linear-gradient(135deg, var(--sumbawa-red) 0%, var(--sumbawa-dark-red) 100%);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            margin-bottom: 15px;
        }
        
        .card-title-modern {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--sumbawa-dark);
            margin-bottom: 10px;
        }
        
        /* Section Styling - Consistent Padding */
        .section-modern {
            padding: 60px 0;
        }
        
        @media (max-width: 768px) {
            .section-modern {
                padding: 40px 0;
            }
        }
        
        @media (max-width: 576px) {
            .section-modern {
                padding: 30px 0;
            }
        }
        
        /* Content Container Spacing */
        .content-wrapper {
            padding: 40px 0;
        }
        
        @media (max-width: 768px) {
            .content-wrapper {
                padding: 25px 0;
            }
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        @media (max-width: 768px) {
            .section-header {
                margin-bottom: 25px;
            }
        }
        
        .section-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--sumbawa-dark);
            position: relative;
            display: inline-block;
            margin-bottom: 15px;
        }
        
        .section-header h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, var(--sumbawa-red), var(--sumbawa-gold));
            border-radius: 2px;
        }
        
        @media (max-width: 768px) {
            .section-header h2 {
                font-size: 1.6rem;
            }
            
            .section-header h2::after {
                bottom: -8px;
                width: 40px;
                height: 3px;
            }
        }
        
        .section-header p {
            color: #666;
            margin-top: 20px;
            font-size: 1rem;
            margin-bottom: 0;
        }
        
        @media (max-width: 768px) {
            .section-header p {
                font-size: 0.9rem;
                margin-top: 15px;
            }
        }
        
        /* Modern Footer */
        .modern-footer {
            background: linear-gradient(135deg, var(--sumbawa-dark) 0%, var(--sumbawa-dark-red) 100%);
            color: white;
            padding: 60px 0 30px;
            position: relative;
        }
        
        .modern-footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--sumbawa-gold), var(--sumbawa-light-gold), var(--sumbawa-gold));
        }
        
        .footer-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: var(--sumbawa-gold);
        }
        
        .footer-links a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }
        
        .footer-links a:hover {
            color: var(--sumbawa-gold);
            padding-left: 5px;
        }
        
        .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            color: white;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            background: var(--sumbawa-gold);
            color: var(--sumbawa-dark);
            transform: translateY(-3px);
        }
        
        .copyright {
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-top: 40px;
            padding-top: 30px;
            text-align: center;
            color: rgba(255,255,255,0.6);
        }
        
        /* Stats Counter */
        .stat-box {
            background: white;
            border-radius: 20px;
            padding: 40px 20px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            border-bottom: 4px solid var(--sumbawa-red);
        }
        
        .stat-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 60px rgba(168, 50, 50, 0.1);
        }
        
        .stat-number {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            font-weight: 700;
            color: var(--sumbawa-red);
            margin-bottom: 10px;
        }
        
        .stat-label {
            color: #666;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        /* Badge Kategori Modern */
        .badge-kategori {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            border: 2px solid var(--sumbawa-gold);
            color: var(--sumbawa-dark);
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .badge-kategori:hover {
            background: var(--sumbawa-red);
            border-color: var(--sumbawa-red);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(168, 50, 50, 0.2);
        }
        
        /* Mobile Navbar Toggle */
        .navbar-toggler-custom {
            border: 2px solid rgba(255,255,255,0.5);
            background: rgba(255,255,255,0.1);
            padding: 8px 15px;
            border-radius: 8px;
            color: white;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
        }
        
        .navbar-toggler-custom:hover {
            background: rgba(255,255,255,0.2);
        }
        
        .mobile-toggle {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }
        
        .mobile-menu {
            display: none;
            background: linear-gradient(135deg, #B83B3B 0%, #8B2C2C 100%);
            border-radius: 12px;
            margin-top: 15px;
            padding: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .mobile-menu.show {
            display: block;
            animation: slideDown 0.3s ease;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .mobile-menu .nav-link {
            padding: 14px 18px !important;
            border-bottom: 1px solid rgba(255,255,255,0.15);
            color: white !important;
            font-weight: 500;
            display: flex;
            align-items: center;
        }
        
        .mobile-menu .nav-link:hover {
            background: rgba(255,255,255,0.15);
            border-radius: 8px;
        }
        
        .mobile-menu .nav-link:last-child {
            border-bottom: none;
        }
        
        .mobile-menu .mobile-login-btn {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid rgba(255,255,255,0.2);
        }
        
        .mobile-menu .mobile-login-btn .nav-link {
            background: var(--sumbawa-gold);
            color: var(--sumbawa-dark) !important;
            border-radius: 25px;
            text-align: center;
            justify-content: center;
            font-weight: 600;
        }
        
        .mobile-menu .mobile-login-btn .nav-link:hover {
            background: var(--sumbawa-light-gold);
        }
        
        /* Responsive */
        @media (max-width: 991px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
            
            .section-header h2 {
                font-size: 1.5rem;
            }
            
            .search-modern {
                width: 100%;
                margin-top: 15px;
            }
            
            .brand-text h1 {
                font-size: 1.3rem;
            }
            
            .brand-text span {
                font-size: 0.75rem;
            }
            
            .modern-card .card-img-wrapper {
                height: 180px;
            }
            
            .stat-number {
                font-size: 2rem;
            }
            
            .section-modern {
                padding: 50px 0;
            }
            
            .desktop-nav {
                display: none !important;
            }
            
            .mobile-toggle {
                display: flex !important;
            }
            
            /* Hide user dropdown and login button in header on mobile - move to canvas menu */
            .header-top .dropdown-user-menu,
            .header-top .header-login-btn {
                display: none !important;
            }
        }
        
        @media (max-width: 767px) {
            .dropdown-user-menu .dropdown-menu-user {
                top: 70px !important;
                right: 10px !important;
            }
            
            .hero-title {
                font-size: 1.7rem;
            }
            
            .hero-modern {
                padding: 80px 0 100px;
            }
            
            .section-header h2 {
                font-size: 1.3rem;
            }
            
            .section-header p {
                font-size: 0.95rem;
            }
            
            .btn-hero {
                padding: 12px 30px;
                font-size: 0.9rem;
            }
            
            .modern-card .card-title-modern {
                font-size: 1.1rem;
            }
            
            .footer-title {
                font-size: 1.2rem;
            }
            
            .stat-box {
                padding: 25px 15px;
            }
            
            .stat-label {
                font-size: 0.75rem;
            }
        }
        
        @media (max-width: 575px) {
            .hero-title {
                font-size: 1.5rem;
            }
            
            .brand-text h1 {
                font-size: 1.1rem;
            }
            
            .brand-text span {
                font-size: 0.7rem;
                letter-spacing: 1px;
            }
            
            .hero-subtitle {
                font-size: 0.9rem;
            }
            
            .card-title-modern {
                font-size: 1rem;
            }
            
            .section-header {
                margin-bottom: 30px;
            }
            
            .section-header h2::after {
                bottom: -10px;
                width: 40px;
                height: 3px;
            }
            
            /* Hide user dropdown and login button on small mobile screens */
            .header-top .dropdown-user-menu,
            .header-top .header-login-btn {
                display: none !important;
            }
        }
        
        @media (min-width: 992px) {
            .mobile-toggle {
                display: none !important;
            }
            
            .mobile-menu {
                display: none !important;
            }
            
            /* Show user dropdown and login button in header on desktop */
            .header-top .dropdown-user-menu,
            .header-top .header-login-btn {
                display: inline-block !important;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Modern Header -->
    <header class="modern-header">
        <div class="header-top">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6">
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ asset('sumbawa.png') }}" alt="Logo Sumbawa" 
                                 style="height: 55px; width: auto; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));">
                            <div class="brand-text">
                                <h1>Portal Seniman</h1>
                                <span>Sumbawa Besar</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 d-flex justify-content-end align-items-center">
                        @guest
                            <a href="{{ route('login') }}" class="btn header-login-btn" style="background: var(--sumbawa-gold); color: var(--sumbawa-dark); border-radius: 25px; padding: 10px 25px; font-weight: 600; box-shadow: 0 4px 15px rgba(212, 165, 116, 0.3); transition: all 0.3s ease;">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Login
                            </a>
                        @else
                            <div class="dropdown dropdown-user-menu ms-auto">
                                <button class="btn dropdown-toggle d-flex align-items-center" style="background: rgba(255,255,255,0.2); color: white; border-radius: 25px; padding: 8px 16px; border: 1px solid rgba(255,255,255,0.3); height: 40px; line-height: 1;" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-person-circle me-2" style="font-size: 1.1rem;"></i>
                                    <span style="max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ Str::limit(Auth::user()->nama, 15) }}</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-user">
                                    @if(Auth::user()->isAdmin())
                                        <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard Admin</a></li>
                                    @else
                                        <li><a class="dropdown-item" href="{{ route('seniman.dashboard') }}"><i class="bi bi-palette me-2"></i> Dashboard Seniman</a></li>
                                    @endif
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modern Navbar -->
        <nav class="modern-navbar">
            <div class="container">
                <!-- Desktop Nav -->
                <div class="desktop-nav">
                    <ul class="nav navbar-nav d-flex flex-row justify-content-center flex-wrap">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                <i class="bi bi-house-door me-1"></i> Beranda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('karya.*') ? 'active' : '' }}" href="{{ route('karya.index') }}">
                                <i class="bi bi-palette me-1"></i> Karya
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('seniman.*') ? 'active' : '' }}" href="{{ route('seniman.index') }}">
                                <i class="bi bi-people me-1"></i> Seniman
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}" href="{{ route('kategori.index') }}">
                                <i class="bi bi-tags me-1"></i> Kategori
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('kata-sambutan') ? 'active' : '' }}" href="{{ route('kata-sambutan') }}">
                                <i class="bi bi-chat-square-quote me-1"></i> Sambutan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('profil') ? 'active' : '' }}" href="{{ route('profil') }}">
                                <i class="bi bi-info-circle me-1"></i> Profil
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Mobile Toggle (Right aligned) -->
                <div class="mobile-toggle py-2">
                    <button class="navbar-toggler-custom" onclick="toggleMobileMenu()">
                        <i class="bi bi-list fs-4"></i>
                        <span>Menu</span>
                    </button>
                </div>
                
                <!-- Mobile Menu (Canvas style) -->
                <div class="mobile-menu" id="mobileMenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                <i class="bi bi-house-door me-2"></i> Beranda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('karya.*') ? 'active' : '' }}" href="{{ route('karya.index') }}">
                                <i class="bi bi-palette me-2"></i> Karya Seni
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('seniman.*') ? 'active' : '' }}" href="{{ route('seniman.index') }}">
                                <i class="bi bi-people me-2"></i> Seniman
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}" href="{{ route('kategori.index') }}">
                                <i class="bi bi-tags me-2"></i> Kategori
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('kata-sambutan') ? 'active' : '' }}" href="{{ route('kata-sambutan') }}">
                                <i class="bi bi-chat-square-quote me-2"></i> Sambutan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('profil') ? 'active' : '' }}" href="{{ route('profil') }}">
                                <i class="bi bi-info-circle me-2"></i> Profil Portal
                            </a>
                        </li>
                        @guest
                        <li class="nav-item mobile-login-btn">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Login / Daftar
                            </a>
                        </li>
                        @else
                        <li class="nav-item mobile-login-btn">
                            <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout ({{ Str::limit(Auth::user()->nama, 10) }})
                            </a>
                            <form id="mobile-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Modern Footer -->
    <footer class="modern-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <h4 class="footer-title">Portal Karya Seniman</h4>
                    <p class="text-white-50">
                        Menampilkan dan melestarikan karya seniman budaya Sumbawa Besar untuk generasi mendatang.
                    </p>
                    <div class="mt-3">
                        <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="footer-title" style="font-size: 1.1rem;">Menu</h5>
                    <div class="footer-links">
                        <a href="{{ route('home') }}">Beranda</a>
                        <a href="{{ route('karya.index') }}">Karya Seni</a>
                        <a href="{{ route('seniman.index') }}">Seniman</a>
                        <a href="{{ route('kategori.index') }}">Kategori</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="footer-title" style="font-size: 1.1rem;">Tentang</h5>
                    <div class="footer-links">
                        <a href="{{ route('profil') }}">Profil Portal</a>
                        <a href="{{ route('kata-sambutan') }}">Kata Sambutan</a>
                        <a href="{{ route('login') }}">Login Seniman</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="footer-title" style="font-size: 1.1rem;">Kontak</h5>
                    <p class="text-white-50">
                        <i class="bi bi-envelope me-2"></i> info@portalseniman.id<br>
                        <i class="bi bi-telephone me-2"></i> (0371) 123456<br>
                        <i class="bi bi-geo-alt me-2"></i> Sumbawa Besar, NTB
                    </p>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; {{ date('Y') }} Portal Karya Seniman Sumbawa Besar. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Mobile Menu Toggle -->
    <script>
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('show');
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            const mobileMenu = document.getElementById('mobileMenu');
            const toggle = document.querySelector('.navbar-toggler-custom');
            if (!mobileMenu.contains(e.target) && !toggle.contains(e.target)) {
                mobileMenu.classList.remove('show');
            }
        });

        // Fixed Navbar Effect
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.querySelector('.modern-navbar');
            const header = document.querySelector('.header-top');
            const body = document.body;

            if (navbar && header) {
                const headerHeight = header.offsetHeight;

                window.addEventListener('scroll', function() {
                    if (window.scrollY > headerHeight) {
                        navbar.classList.add('fixed');
                        body.style.paddingTop = navbar.offsetHeight + 'px';
                    } else {
                        navbar.classList.remove('fixed');
                        body.style.paddingTop = '0';
                    }
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
