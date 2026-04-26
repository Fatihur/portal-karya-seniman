<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portal Karya Seniman Sumbawa Besar')</title>

    <link rel="shortcut icon" href="{{ asset('sumbawa.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <!-- Global Styles -->
    <style>
        :root {
            --primary: #0f766e;
            --primary-dark: #134e4a;
            --primary-light: #f0fdfa;
            --accent: #d97706;
            --accent-light: #fffbeb;
            --surface: #ffffff;
            --bg: #f8fafc;
            --text: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --radius: 12px;
            --radius-sm: 8px;
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        html, body {
            height: 100%;
        }

        body {
            background-color: var(--bg);
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--text);
            -webkit-font-smoothing: antialiased;
            display: flex;
            flex-direction: column;
        }

        h1, h2, h3, h4, h5, h6, .font-display {
            font-family: 'Playfair Display', Georgia, serif;
        }

        .navbar-main {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border);
            box-shadow: var(--shadow);
        }

        .navbar-main .navbar-brand {
            color: var(--primary-dark);
        }

        .navbar-logo {
            height: 52px;
        }

        @media (max-width: 767px) {
            .navbar-logo {
                height: 42px;
            }
        }

        .nav-link-btn {
            color: var(--primary);
            border: 1.5px solid var(--primary);
            border-radius: 100px;
            padding: 8px 24px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .nav-link-btn:hover {
            background: var(--primary);
            color: #fff;
        }

        /* Sidebar */
        .sidebar-card {
            background: var(--surface);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            border: 1px solid var(--border);
        }

        .sidebar-card .list-group-item {
            border: none;
            padding: 14px 20px;
            font-weight: 500;
            color: var(--text);
            transition: all 0.15s ease;
            border-radius: 0 !important;
        }

        .sidebar-card .list-group-item:hover {
            background: var(--primary-light);
            color: var(--primary);
        }

        .sidebar-card .list-group-item.active {
            background: var(--primary-light);
            color: var(--primary);
            font-weight: 700;
            border-left: 3px solid var(--primary);
        }

        .sidebar-card .accordion-button {
            background: var(--surface);
            color: var(--text);
            font-weight: 600;
            padding: 14px 20px;
            box-shadow: none;
        }

        .sidebar-card .accordion-button:not(.collapsed) {
            background: var(--primary-light);
            color: var(--primary);
        }

        .sidebar-card .accordion-button::after {
            filter: invert(30%) sepia(15%) saturate(1000%) hue-rotate(130deg);
        }

        .sidebar-card .accordion-body .list-group-item {
            padding-left: 36px;
            font-size: 0.9rem;
        }

        /* Mobile offcanvas */
        .offcanvas-modern {
            width: 300px;
            border: none;
        }

        .offcanvas-modern .offcanvas-header {
            background: var(--primary-dark);
            color: white;
        }

        .offcanvas-modern .list-group-item.active {
            background: var(--primary);
            color: white;
            border-left: none;
        }

        .offcanvas-modern .accordion-button {
            background: var(--primary);
            color: white;
        }

        .offcanvas-modern .accordion-button:not(.collapsed) {
            background: var(--primary-dark);
            color: white;
        }

        .offcanvas-modern .accordion-button::after {
            filter: brightness(0) invert(1);
        }

        .offcanvas-modern .accordion-body .list-group-item.active {
            background: var(--primary-light);
            color: var(--primary);
        }

        /* Content area */
        .content-area {
            background: var(--surface);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            min-height: 600px;
        }

        @media (max-width: 767px) {
            .content-area {
                border-radius: 0;
                border-left: none;
                border-right: none;
                box-shadow: none;
            }
        }

        /* Footer */
        .footer-main {
            background: var(--primary-dark);
            color: rgba(255,255,255,0.85);
            font-size: 0.875rem;
        }

        /* Utilities */
        .btn-accent {
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 100px;
            padding: 8px 24px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-accent:hover {
            background: #b45309;
            color: white;
        }

        .btn-primary-custom {
            background: var(--primary);
            color: white;
            border: none;
            border-radius: var(--radius-sm);
            padding: 8px 20px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-primary-custom:hover {
            background: var(--primary-dark);
            color: white;
        }

        .badge-primary {
            background: var(--primary-light);
            color: var(--primary);
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
    </style>

    <!-- Page Specific Styles -->
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-main fixed-top py-2">
        <div class="container" style="max-width: 1200px;">
            <div class="d-flex align-items-center">
                <button class="navbar-toggler border-0 me-2 d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
                    <i class="bi bi-list fs-4" style="color: var(--primary);"></i>
                </button>
                <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                    <img src="{{ asset('sumbawa.png') }}" alt="Logo Sumbawa" class="navbar-logo">
                    <div class="ms-2">
                        <div style="font-size: 13px; line-height: 1.3; color: var(--text-muted); font-weight: 600; letter-spacing: 0.5px; font-family: 'Plus Jakarta Sans', sans-serif;">PORTAL KARYA SENIMAN</div>
                        <div style="font-size: 22px; line-height: 1.1; color: var(--primary-dark); font-weight: 700; font-family: 'Playfair Display', serif;">Sumbawa Besar</div>
                    </div>
                </a>
            </div>

            <div class="d-none d-lg-flex align-items-center">
                @guest
                <a href="{{ route('login') }}" class="nav-link-btn">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Login
                </a>
                @else
                @if(Auth::user()->peran === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="nav-link-btn">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
                @elseif(Auth::user()->peran === 'seniman')
                <a href="{{ route('seniman.dashboard') }}" class="nav-link-btn">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
                @endif
                @endguest
            </div>
        </div>
    </nav>

    <!-- Mobile Sidebar Offcanvas -->
    <div class="offcanvas offcanvas-start offcanvas-modern" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title font-display" id="mobileSidebarLabel">Menu</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div class="list-group list-group-flush">
                <a href="{{ route('home') }}" class="list-group-item list-group-item-action py-3 {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="bi bi-house-door me-2"></i> Beranda
                </a>
                <a href="{{ route('kata-sambutan') }}" class="list-group-item list-group-item-action py-3 {{ request()->routeIs('kata-sambutan') ? 'active' : '' }}">
                    <i class="bi bi-chat-square-quote me-2"></i> Kata Sambutan
                </a>
            </div>

            <div class="accordion rounded-0" id="mobileCategoryAccordion">
                <div class="accordion-item border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-semibold py-3 {{ request()->is('kategori*') ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#mobileCategoryCollapse" aria-expanded="{{ request()->is('kategori*') ? 'true' : 'false' }}">
                            <i class="bi bi-tags me-2"></i> Kategori
                        </button>
                    </h2>
                    <div id="mobileCategoryCollapse" class="accordion-collapse collapse {{ request()->is('kategori*') ? 'show' : '' }}" data-bs-parent="#mobileCategoryAccordion">
                        <div class="accordion-body p-0">
                            <div class="list-group list-group-flush">
                                @foreach($layoutKategoriList as $kat)
                                <a href="{{ route('kategori.show', $kat->slug) }}" class="list-group-item list-group-item-action ps-4 py-2 {{ request()->is('kategori/'.$kat->slug) ? 'active' : '' }}">
                                    {{ $kat->nama_kategori }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="list-group list-group-flush">
                <a href="{{ route('seniman.index') }}" class="list-group-item list-group-item-action py-3 {{ request()->routeIs('seniman.*') ? 'active' : '' }}">
                    <i class="bi bi-people me-2"></i> Seniman
                </a>
                <a href="{{ route('karya.index') }}" class="list-group-item list-group-item-action py-3 {{ request()->routeIs('karya.*') ? 'active' : '' }}">
                    <i class="bi bi-palette me-2"></i> Karya Seni
                </a>
                @guest
                <a href="{{ route('login') }}" class="list-group-item list-group-item-action py-3">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Login
                </a>
                @else
                <a href="#" class="list-group-item list-group-item-action py-3" onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
                <form id="mobile-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                @endguest
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container flex-grow-1" style="max-width: 1200px; margin-top: 90px; padding-bottom: 40px;">
        <div class="row g-4">
            <!-- Sidebar Desktop -->
            <aside class="col-lg-3 col-md-4 d-none d-md-block">
                <div class="position-sticky" style="top: 100px;">
                    <div class="sidebar-card mb-3">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('home') }}" class="list-group-item list-group-item-action {{ request()->routeIs('home') ? 'active' : '' }}">
                                <i class="bi bi-house-door me-2"></i> Beranda
                            </a>
                            <a href="{{ route('kata-sambutan') }}" class="list-group-item list-group-item-action {{ request()->routeIs('kata-sambutan') ? 'active' : '' }}">
                                <i class="bi bi-chat-square-quote me-2"></i> Kata Sambutan
                            </a>
                        </div>
                    </div>

                    <div class="sidebar-card mb-3">
                        <div class="accordion" id="desktopCategoryAccordion">
                            <div class="accordion-item border-0">
                                <h2 class="accordion-header">
                                    <button class="accordion-button fw-semibold {{ request()->is('kategori*') ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#desktopCategoryCollapse" aria-expanded="{{ request()->is('kategori*') ? 'true' : 'false' }}">
                                        <i class="bi bi-tags me-2"></i> Kategori
                                    </button>
                                </h2>
                                <div id="desktopCategoryCollapse" class="accordion-collapse collapse {{ request()->is('kategori*') ? 'show' : '' }}" data-bs-parent="#desktopCategoryAccordion">
                                    <div class="accordion-body p-0">
                                        <div class="list-group list-group-flush">
                                            @foreach($layoutKategoriList as $kat)
                                            <a href="{{ route('kategori.show', $kat->slug) }}" class="list-group-item list-group-item-action {{ request()->is('kategori/'.$kat->slug) ? 'active' : '' }}">
                                                {{ $kat->nama_kategori }}
                                            </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sidebar-card">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('seniman.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('seniman.*') ? 'active' : '' }}">
                                <i class="bi bi-people me-2"></i> Seniman
                            </a>
                            <a href="{{ route('karya.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('karya.*') ? 'active' : '' }}">
                                <i class="bi bi-palette me-2"></i> Karya Seni
                            </a>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content Area -->
            <section class="col-lg-9 col-md-8">
                <div class="content-area p-4 p-md-4">
                    @yield('content')
                </div>
            </section>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer-main py-4 mt-auto sticky-bottom">
        <div class="container" style="max-width: 1200px;">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                    <span class="font-display fw-bold">Portal Karya Seniman Sumbawa Besar</span>
                    <span class="d-block d-md-inline ms-md-2 opacity-75">&copy; {{ date('Y') }}</span>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <small class="opacity-75">Melestarikan budaya melalui karya seni</small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- Page Specific Scripts -->
    @stack('scripts')
</body>
</html>
