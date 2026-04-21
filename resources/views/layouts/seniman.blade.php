<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Seniman') | Portal Karya Seniman</title>

    <link rel="shortcut icon" href="{{ asset('sumbawa.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <style>
        :root {
            --sumbawa-red: #b63124;
            --sumbawa-red-dark: #9e2b20;
        }

        * {
            -webkit-tap-highlight-color: transparent;
        }

        body {
            background-color: #f5f5f5;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            overflow-x: hidden;
        }

        .admin-navbar {
            background-color: var(--sumbawa-red);
        }

        .admin-navbar .navbar-logo {
            height: 40px;
        }

        @media (max-width: 575px) {
            .admin-navbar .navbar-logo {
                height: 35px;
            }
        }

        .offcanvas-sidebar {
            width: 280px;
            background-color: #fff;
            z-index: 1050;
        }

        .offcanvas-backdrop {
            z-index: 1040;
        }

        .offcanvas-sidebar .offcanvas-header {
            background-color: var(--sumbawa-red);
            color: white;
        }

        .offcanvas-sidebar .list-group-item {
            border-left: none;
            border-right: none;
            padding: 12px 16px;
            cursor: pointer;
        }

        .offcanvas-sidebar .list-group-item.active {
            background-color: var(--sumbawa-red);
            border-color: var(--sumbawa-red);
        }

        .mobile-toggle {
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255,255,255,0.5);
            border-radius: 4px;
            background: transparent;
            cursor: pointer;
        }

        .mobile-toggle:hover {
            background: rgba(255,255,255,0.1);
        }

        .sidebar-desktop {
            background-color: #fff;
            min-height: calc(100vh - 56px);
            border-right: 1px solid #dee2e6;
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
            padding: 12px 16px;
        }

        .sidebar-desktop .list-group-item:hover {
            background-color: #f8f9fa;
        }

        .sidebar-desktop .list-group-item.active {
            background-color: var(--sumbawa-red);
            border-color: var(--sumbawa-red);
        }

        .admin-content {
            background-color: #fff;
            min-height: calc(100vh - 56px);
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
            background: #888;
            border-radius: 3px;
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
    <nav class="navbar navbar-expand admin-navbar navbar-dark sticky-top">
        <div class="container-fluid px-3">
            <div class="d-flex align-items-center">
                <button class="mobile-toggle text-white me-2 d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar" aria-label="Toggle menu">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <a class="navbar-brand d-flex align-items-center p-0" href="{{ route('seniman.dashboard') }}">
                    <img src="{{ asset('sumbawa.png') }}" alt="Logo" class="navbar-logo me-2">
                    <span class="fw-bold text-white d-none d-sm-block">Panel Seniman</span>
                    <span class="fw-bold text-white d-sm-none" style="font-size: 14px;">Seniman</span>
                </a>
            </div>

            <div class="dropdown">
                <button class="btn btn-link text-white p-0 dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle fs-5"></i>
                    <span class="d-none d-md-inline ms-2">{{ Str::limit(Auth::user()->nama, 15) }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow">
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
            <h5 class="offcanvas-title" id="mobileSidebarLabel">Menu Seniman</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div class="list-group list-group-flush" id="mobileMenu">
                <a href="{{ route('seniman.dashboard') }}" class="list-group-item list-group-item-action py-3 {{ request()->routeIs('seniman.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>

                <div class="list-group-item bg-light fw-bold text-uppercase small py-2 text-muted">
                    Karya Saya
                </div>

                <a href="{{ route('seniman.karya.index') }}" class="list-group-item list-group-item-action py-3 {{ request()->routeIs('seniman.karya.index') ? 'active' : '' }}">
                    <i class="bi bi-palette me-2"></i> Daftar Karya
                </a>

                <a href="{{ route('seniman.karya.create') }}" class="list-group-item list-group-item-action py-3 {{ request()->routeIs('seniman.karya.create') ? 'active' : '' }}">
                    <i class="bi bi-plus-circle me-2"></i> Tambah Karya
                </a>

                <div class="list-group-item bg-light fw-bold text-uppercase small py-2 text-muted">
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

                    <div class="list-group-item bg-light fw-bold text-uppercase small py-2 text-muted">
                        Karya Saya
                    </div>

                    <a href="{{ route('seniman.karya.index') }}" class="list-group-item py-3 {{ request()->routeIs('seniman.karya.index') ? 'active' : '' }}">
                        <i class="bi bi-palette me-2"></i> Daftar Karya
                    </a>

                    <a href="{{ route('seniman.karya.create') }}" class="list-group-item py-3 {{ request()->routeIs('seniman.karya.create') ? 'active' : '' }}">
                        <i class="bi bi-plus-circle me-2"></i> Tambah Karya
                    </a>

                    <div class="list-group-item bg-light fw-bold text-uppercase small py-2 text-muted">
                        Akun
                    </div>

                    <a href="{{ route('seniman.profil.edit') }}" class="list-group-item py-3 {{ request()->routeIs('seniman.profil.*') ? 'active' : '' }}">
                        <i class="bi bi-person me-2"></i> Profil Saya
                    </a>
                </div>
            </aside>

            <main class="col-md-9 col-lg-10 admin-content p-3 p-md-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle-fill me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(trim($__env->yieldContent('content_header')))
                    <div class="mb-4">
                        @yield('content_header')
                    </div>
                @else
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
                        <h1 class="h4 mb-0">@yield('title', 'Dashboard Seniman')</h1>
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
