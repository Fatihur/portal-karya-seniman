<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Seniman') | Portal Karya Seniman</title>

    <link rel="shortcut icon" href="{{ asset('sumbawa.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary: #0f766e;
            --primary-dark: #134e4a;
            --primary-light: #f0fdfa;
            --accent: #d97706;
            --surface: #ffffff;
            --bg: #f8fafc;
            --text: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --radius: 12px;
            --radius-sm: 8px;
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }

        * {
            -webkit-tap-highlight-color: transparent;
        }

        body {
            background-color: var(--bg);
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--text);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, h5, h6, .font-display {
            font-family: 'Poppins', Georgia, serif;
        }

        .admin-navbar {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border);
            box-shadow: var(--shadow);
            z-index: 1040;
        }

        .admin-navbar .navbar-brand {
            color: var(--primary-dark);
        }

        .admin-navbar .navbar-logo {
            height: 38px;
        }

        @media (max-width: 575px) {
            .admin-navbar .navbar-logo {
                height: 32px;
            }
        }

        .mobile-toggle {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            background: transparent;
            cursor: pointer;
            color: var(--primary);
            transition: all 0.2s;
        }

        .mobile-toggle:hover {
            background: var(--primary-light);
            border-color: var(--primary);
        }

        .offcanvas-sidebar {
            width: 280px;
            background-color: var(--surface);
            z-index: 1050;
            border: none;
        }

        .offcanvas-backdrop {
            z-index: 1040;
        }

        .offcanvas-sidebar .offcanvas-header {
            background-color: var(--primary-dark);
            color: white;
        }

        .offcanvas-sidebar .list-group-item {
            border-left: none;
            border-right: none;
            padding: 12px 16px;
            cursor: pointer;
            color: var(--text);
            transition: all 0.15s ease;
        }

        .offcanvas-sidebar .list-group-item.active {
            background-color: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        .sidebar-desktop {
            background-color: var(--surface);
            min-height: calc(100vh - 62px);
            border-right: 1px solid var(--border);
        }

        @media (max-width: 767px) {
            .sidebar-desktop {
                display: none !important;
            }
        }

        .sidebar-desktop .list-group-item {
            border-left: none;
            border-right: none;
            border-radius: 0;
            padding: 12px 20px;
            color: var(--text);
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.15s ease;
        }

        .sidebar-desktop .list-group-item:hover {
            background-color: var(--primary-light);
            color: var(--primary);
        }

        .admin-content,
        .admin-content .page-title-bar,
        .admin-content .card,
        .admin-content .card-body,
        .admin-content .card-header,
        .admin-content .table,
        .admin-content .table th,
        .admin-content .table td,
        .admin-content .form-label,
        .admin-content .btn,
        .admin-content .badge {
            font-size: 1rem;
        }

        .admin-content .card-body h6,
        .admin-content .card-body .text-muted {
            font-size: 1rem;
        }

        .admin-content .card-body h3,
        .admin-content .page-title-bar h1,
        .admin-content .page-title-bar h2 {
            font-size: 1.25rem;
        }

        .sidebar-desktop .list-group-item.active {
            background-color: var(--primary-light);
            color: var(--primary);
            border-left: 3px solid var(--primary);
            font-weight: 700;
        }

        .sidebar-desktop .list-group-item.bg-light {
            background: var(--bg) !important;
            color: var(--text-muted) !important;
            font-size: 0.7rem;
            letter-spacing: 0.5px;
        }

        .admin-content {
            background-color: var(--bg);
            min-height: calc(100vh - 62px);
        }

        .card-modern {
            background: var(--surface);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
        }

        .table-responsive-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-responsive-wrapper table {
            min-width: 600px;
        }

        .table-responsive-wrapper::-webkit-scrollbar {
            height: 6px;
        }

        .table-responsive-wrapper::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .table-responsive-wrapper::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .btn-primary-custom {
            background: var(--primary);
            color: white;
            border: none;
        }

        .btn-primary-custom:hover {
            background: var(--primary-dark);
            color: white;
        }

        .dropdown-menu {
            border: 1px solid var(--border);
            box-shadow: var(--shadow-md);
            border-radius: var(--radius-sm);
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .page-link {
            color: var(--primary);
        }
        .page-item.active .page-link {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .page-title-bar {
            background: var(--surface);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            padding: 20px 24px;
        }

        @media (max-width: 767px) {
            .admin-content {
                padding: 15px !important;
            }
        }

        @media (max-width: 575px) {
            .admin-content {
                padding: 10px !important;
            }

            .card-header h6 {
                font-size: 14px;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand admin-navbar sticky-top">
        <div class="container-fluid px-3">
            <div class="d-flex align-items-center">
                <button class="mobile-toggle me-2 d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar" aria-label="Toggle menu">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <a class="navbar-brand d-flex align-items-center p-0" href="{{ route('seniman.dashboard') }}">
                    <img src="{{ asset('sumbawa.png') }}" alt="Logo" class="navbar-logo me-2">
                    <span class="fw-bold d-none d-sm-block font-display">Panel Seniman</span>
                    <span class="fw-bold d-sm-none font-display" style="font-size: 15px;">Seniman</span>
                </a>
            </div>

            <div class="dropdown">
                <button class="btn btn-link p-0 dropdown-toggle d-flex align-items-center text-decoration-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: var(--text);">
                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="bi bi-person fs-5" style="color: var(--primary);"></i>
                    </div>
                    <span class="d-none d-md-inline ms-2 fw-semibold small">{{ Str::limit(Auth::user()->nama, 15) }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('home') }}" target="_blank">
                            <i class="bi bi-globe me-2 text-primary"></i> Lihat Website
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <span class="dropdown-item-text text-muted">
                            <small>{{ Auth::user()->email }}</small>
                        </span>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <div class="offcanvas offcanvas-start offcanvas-sidebar" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title font-display" id="mobileSidebarLabel">Menu Seniman</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div class="list-group list-group-flush" id="mobileMenu">
                <a href="{{ route('seniman.dashboard') }}" class="list-group-item list-group-item-action py-3 {{ request()->routeIs('seniman.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>

                <div class="list-group-item bg-light fw-bold text-uppercase small py-2">
                    Karya Saya
                </div>

                <a href="{{ route('seniman.karya.index') }}" class="list-group-item list-group-item-action py-3 {{ request()->routeIs('seniman.karya.index') ? 'active' : '' }}">
                    <i class="bi bi-palette me-2"></i> Daftar Karya
                </a>

                <a href="{{ route('seniman.karya.create') }}" class="list-group-item list-group-item-action py-3 {{ request()->routeIs('seniman.karya.create') ? 'active' : '' }}">
                    <i class="bi bi-plus-circle me-2"></i> Tambah Karya
                </a>

                <div class="list-group-item bg-light fw-bold text-uppercase small py-2">
                    Akun
                </div>

                <a href="{{ route('seniman.profil.edit') }}" class="list-group-item list-group-item-action py-3 {{ request()->routeIs('seniman.profil.*') ? 'active' : '' }}">
                    <i class="bi bi-person me-2"></i> Profil Saya
                </a>
            </div>
        </div>
    </div>

    <div class="container-fluid px-0">
        <div class="row g-0">
            <aside class="col-md-3 col-lg-2 sidebar-desktop d-none d-md-block">
                <div class="list-group list-group-flush">
                    <a href="{{ route('seniman.dashboard') }}" class="list-group-item py-3 {{ request()->routeIs('seniman.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>

                    <div class="list-group-item bg-light fw-bold text-uppercase small py-2">
                        Karya Saya
                    </div>

                    <a href="{{ route('seniman.karya.index') }}" class="list-group-item py-3 {{ request()->routeIs('seniman.karya.index') ? 'active' : '' }}">
                        <i class="bi bi-palette me-2"></i> Daftar Karya
                    </a>

                    <a href="{{ route('seniman.karya.create') }}" class="list-group-item py-3 {{ request()->routeIs('seniman.karya.create') ? 'active' : '' }}">
                        <i class="bi bi-plus-circle me-2"></i> Tambah Karya
                    </a>

                    <div class="list-group-item bg-light fw-bold text-uppercase small py-2">
                        Akun
                    </div>

                    <a href="{{ route('seniman.profil.edit') }}" class="list-group-item py-3 {{ request()->routeIs('seniman.profil.*') ? 'active' : '' }}">
                        <i class="bi bi-person me-2"></i> Profil Saya
                    </a>
                </div>
            </aside>

            <main class="col-md-9 col-lg-10 admin-content p-3 p-md-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0" style="background: #ecfdf5; color: #065f46; border-radius: var(--radius-sm);" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show border-0" style="background: #fef2f2; color: #991b1b; border-radius: var(--radius-sm);" role="alert">
                        <i class="bi bi-exclamation-circle-fill me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show border-0" style="background: #fffbeb; color: #92400e; border-radius: var(--radius-sm);" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(trim($__env->yieldContent('content_header')))
                    <div class="mb-4">
                        @yield('content_header')
                    </div>
                @else
                    <div class="page-title-bar d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
                        <h1 class="h4 mb-0 font-display">@yield('title', 'Dashboard Seniman')</h1>
                        <span class="text-muted small">{{ now()->format('d F Y') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileSidebar = document.getElementById('mobileSidebar');
            const menuLinks = document.querySelectorAll('#mobileMenu .list-group-item-action');

            menuLinks.forEach(function(link) {
                link.addEventListener('click', function() {
                    const bsOffcanvas = bootstrap.Offcanvas.getInstance(mobileSidebar);
                    if (bsOffcanvas) {
                        bsOffcanvas.hide();
                    }
                });
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
