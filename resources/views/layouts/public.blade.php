<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portal Karya Seniman Sumbawa Besar')</title>
    
    <link rel="shortcut icon" href="{{ asset('sumbawa.png') }}">
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    
    <!-- Global Styles -->
    <style>
        :root {
            --sumbawa-red: #b63124;
        }
        
        body {
            background-color: #f5f5f5;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }
        
        .navbar-logo {
            height: 65px;
        }
        
        @media (max-width: 767px) {
            .navbar-logo {
                height: 50px;
            }
        }
    </style>
    
    <!-- Page Specific Styles -->
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg bg-danger navbar-dark fixed-top py-2">
        <div class="container" style="max-width: 1200px;">
            <div class="d-flex align-items-center">
                <button class="navbar-toggler border-light me-2 d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                    <img src="{{ asset('sumbawa.png') }}" alt="Logo Sumbawa" class="navbar-logo">
                    <div class="ms-2 text-white fw-bold">
                        <div style="font-size: 16px; line-height: 1.2;">PORTAL KARYA SENIMAN</div>
                        <div style="font-size: 28px; line-height: 1;">SUMBAWA BESAR</div>
                    </div>
                </a>
            </div>
            
            <div class="d-none d-lg-flex align-items-center">
                @guest
                <a href="{{ route('login') }}" class="btn btn-outline-light px-4">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Login
                </a>
                @else
                @if(Auth::user()->peran === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light px-4">
                    <i class="bi bi-speedometer2 me-1"></i> Dashboard
                </a>
                @elseif(Auth::user()->peran === 'seniman')
                <a href="{{ route('seniman.dashboard') }}" class="btn btn-outline-light px-4">
                    <i class="bi bi-speedometer2 me-1"></i> Dashboard
                </a>
                @endif
                @endguest
            </div>
        </div>
    </nav>

    <!-- Mobile Sidebar Offcanvas -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel" style="width: 280px;">
        <div class="offcanvas-header bg-danger text-white">
            <h5 class="offcanvas-title" id="mobileSidebarLabel">Menu</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <!-- Main Menu -->
            <div class="list-group list-group-flush rounded-0">
                <a href="{{ route('home') }}" class="list-group-item list-group-item-action py-3 {{ request()->routeIs('home') ? 'active bg-danger border-danger' : '' }}">
                    <i class="bi bi-house-door me-2"></i> Beranda
                </a>
                <a href="{{ route('kata-sambutan') }}" class="list-group-item list-group-item-action py-3 {{ request()->routeIs('kata-sambutan') ? 'active bg-danger border-danger' : '' }}">
                    <i class="bi bi-chat-square-quote me-2"></i> Kata Sambutan
                </a>
            </div>

            <!-- Category Accordion -->
            <div class="accordion rounded-0" id="mobileCategoryAccordion">
                <div class="accordion-item border-0 rounded-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button bg-danger text-white fw-semibold py-3 rounded-0 {{ request()->is('kategori*') ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#mobileCategoryCollapse" aria-expanded="{{ request()->is('kategori*') ? 'true' : 'false' }}" aria-controls="mobileCategoryCollapse">
                            <i class="bi bi-tags me-2"></i> Kategori
                        </button>
                    </h2>
                    <div id="mobileCategoryCollapse" class="accordion-collapse collapse {{ request()->is('kategori*') ? 'show' : '' }}" data-bs-parent="#mobileCategoryAccordion">
                        <div class="accordion-body p-0">
                            <div class="list-group list-group-flush">
                                @foreach($layoutKategoriList as $kat)
                                <a href="{{ route('kategori.show', $kat->slug) }}" class="list-group-item list-group-item-action ps-4 py-2 {{ request()->is('kategori/'.$kat->slug) ? 'active bg-danger-subtle text-danger' : '' }}">
                                    {{ $kat->nama_kategori }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Other Menu -->
            <div class="list-group list-group-flush rounded-0">
                <a href="{{ route('seniman.index') }}" class="list-group-item list-group-item-action py-3 {{ request()->routeIs('seniman.*') ? 'active bg-danger border-danger' : '' }}">
                    <i class="bi bi-people me-2"></i> Seniman
                </a>
                <a href="{{ route('karya.index') }}" class="list-group-item list-group-item-action py-3 {{ request()->routeIs('karya.*') ? 'active bg-danger border-danger' : '' }}">
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
    <main class="container bg-white py-4 flex-grow-1" style="max-width: 1200px; margin-top: 90px; margin-bottom: 70px;">
        <div class="row g-4 h-100">
            <!-- Sidebar Desktop -->
            <aside class="col-lg-3 col-md-4 d-none d-md-block">
                <div class="position-sticky" style="top: 110px;">
                    <div class="list-group mb-3">
                    <a href="{{ route('home') }}" class="list-group-item list-group-item-action {{ request()->routeIs('home') ? 'active bg-danger border-danger' : '' }}">
                        <i class="bi bi-house-door me-2"></i> Beranda
                    </a>
                    <a href="{{ route('kata-sambutan') }}" class="list-group-item list-group-item-action {{ request()->routeIs('kata-sambutan') ? 'active bg-danger border-danger' : '' }}">
                        <i class="bi bi-chat-square-quote me-2"></i> Kata Sambutan
                    </a>
                </div>

                <!-- Category Accordion -->
                <div class="accordion mb-3" id="desktopCategoryAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button bg-danger text-white fw-semibold {{ request()->is('kategori*') ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#desktopCategoryCollapse" aria-expanded="{{ request()->is('kategori*') ? 'true' : 'false' }}" aria-controls="desktopCategoryCollapse">
                                <i class="bi bi-tags me-2"></i> Kategori
                            </button>
                        </h2>
                        <div id="desktopCategoryCollapse" class="accordion-collapse collapse {{ request()->is('kategori*') ? 'show' : '' }}" data-bs-parent="#desktopCategoryAccordion">
                            <div class="accordion-body p-0">
                                <div class="list-group list-group-flush">
                                    @foreach($layoutKategoriList as $kat)
                                    <a href="{{ route('kategori.show', $kat->slug) }}" class="list-group-item list-group-item-action ps-4 {{ request()->is('kategori/'.$kat->slug) ? 'active bg-danger-subtle text-danger' : '' }}">
                                        {{ $kat->nama_kategori }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="list-group">
                    <a href="{{ route('seniman.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('seniman.*') ? 'active bg-danger border-danger' : '' }}">
                        <i class="bi bi-people me-2"></i> Seniman
                    </a>
                    <a href="{{ route('karya.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('karya.*') ? 'active bg-danger border-danger' : '' }}">
                        <i class="bi bi-palette me-2"></i> Karya Seni
                    </a>
                </div>
                </div>
            </aside>

            <!-- Main Content Area -->
            <section class="col-lg-9 col-md-8 border-start ps-4">
                @yield('content')
            </section>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-danger text-white py-3 mt-auto fixed-bottom" style="z-index: 1030;">
        <div class="container" style="max-width: 1200px;">
            &copy; Portal Karya Seniman Sumbawa Besar {{ date('Y') }}
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
    <!-- Page Specific Scripts -->
    @stack('scripts')
</body>
</html>
