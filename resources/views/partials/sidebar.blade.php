<ul class="sidebar-menu">
    <li>
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
            <i class="bi bi-house-door me-2"></i> Beranda
        </a>
    </li>
    <li>
        <a href="{{ route('kata-sambutan') }}" class="{{ request()->routeIs('kata-sambutan') ? 'active' : '' }}">
            <i class="bi bi-chat-square-quote me-2"></i> Kata Sambutan
        </a>
    </li>
    
    @php
        $kategoriList = App\Models\Kategori::aktif()->orderBy('nama_kategori')->get();
        $isKategoriActive = request()->is('kategori*');
    @endphp
    
    <li class="has-submenu {{ $isKategoriActive ? 'active' : '' }}">
        <a href="#" class="submenu-toggle d-flex justify-content-between align-items-center {{ $isKategoriActive ? 'active' : '' }}" onclick="toggleSubmenu(event)">
            <span><i class="bi bi-tags me-2"></i> Kategori</span>
            <i class="bi bi-chevron-down submenu-icon {{ $isKategoriActive ? 'rotate' : '' }}"></i>
        </a>
        <ul class="submenu {{ $isKategoriActive ? 'show' : '' }}">
            @foreach($kategoriList as $kat)
            <li>
                <a href="{{ route('kategori.show', $kat->slug) }}" class="{{ request()->is('kategori/'.$kat->slug) ? 'active' : '' }}">
                    {{ $kat->nama_kategori }}
                </a>
            </li>
            @endforeach
        </ul>
    </li>
    
    <li>
        <a href="{{ route('seniman.index') }}" class="{{ request()->routeIs('seniman.*') ? 'active' : '' }}">
            <i class="bi bi-people me-2"></i> Seniman
        </a>
    </li>
    <li>
        <a href="{{ route('karya.index') }}" class="{{ request()->routeIs('karya.*') ? 'active' : '' }}">
            <i class="bi bi-palette me-2"></i> Karya Seni
        </a>
    </li>
</ul>

<script>
function toggleSubmenu(e) {
    e.preventDefault();
    const parent = e.currentTarget.closest('.has-submenu');
    const submenu = parent.querySelector('.submenu');
    const icon = parent.querySelector('.submenu-icon');
    
    if (submenu.classList.contains('show')) {
        submenu.classList.remove('show');
        icon.classList.remove('rotate');
    } else {
        submenu.classList.add('show');
        icon.classList.add('rotate');
    }
}
</script>

<style>
.has-submenu .submenu {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
    padding-left: 15px;
}

.has-submenu .submenu.show {
    max-height: 500px;
}

.submenu-icon {
    transition: transform 0.3s ease;
    font-size: 0.8rem;
}

.submenu-icon.rotate {
    transform: rotate(180deg);
}

.submenu-toggle {
    cursor: pointer;
}

.submenu-toggle:hover {
    background: var(--sumbawa-red) !important;
    color: white !important;
}

.submenu li a {
    padding: 8px 20px 8px 35px !important;
    font-size: 0.9rem;
}

.submenu li a:hover,
.submenu li a.active {
    background: rgba(184, 59, 59, 0.1) !important;
    color: var(--sumbawa-red) !important;
}
</style>
