@extends('layouts.public')

@section('title', 'Portal Karya Seniman Sumbawa Besar')

@section('content')
    <!-- Hero Section -->
    <section class="hero-modern">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8 hero-content">
                    <h1 class="hero-title">Jelajahi Karya Seniman Sumbawa</h1>
                    <p class="hero-subtitle">
                        Temukan keindahan karya seni, kerajinan tangan, dan warisan budaya 
                        dari para seniman berbakat Sumbawa Besar
                    </p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="{{ route('karya.index') }}" class="btn btn-hero">
                            <i class="bi bi-compass me-2"></i> Jelajahi Karya
                        </a>
                        <a href="{{ route('seniman.index') }}" class="btn btn-outline-light btn-lg rounded-pill px-4">
                            <i class="bi bi-people me-2"></i> Lihat Seniman
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-4" style="background: white;">
        <div class="container">
            <div class="row g-3">
                <div class="col-6 col-lg-3">
                    <div class="stat-box">
                        <div class="stat-number">{{ $totalKarya ?? $karyaUnggulan->count() * 3 }}</div>
                        <div class="stat-label">Karya Seni</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-box">
                        <div class="stat-number">{{ $totalSeniman ?? $senimanUnggulan->count() * 2 }}</div>
                        <div class="stat-label">Seniman</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-box">
                        <div class="stat-number">{{ $kategoriUnggulan->count() }}</div>
                        <div class="stat-label">Kategori</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-box">
                        <div class="stat-number">100+</div>
                        <div class="stat-label">Pengunjung</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Slider/Banner Section -->
    @if($sliders->count() > 0)
    <section class="section-modern py-4" style="background: linear-gradient(180deg, white 0%, var(--sumbawa-cream) 100%);">
        <div class="container">
            <div id="heroSlider" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    @foreach($sliders as $index => $slider)
                    <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}" aria-current="{{ $index == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>
                <div class="carousel-inner rounded-4 shadow-lg" style="overflow: hidden;">
                    @foreach($sliders as $index => $slider)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="position-relative" style="height: 400px;">
                            <img src="{{ asset('storage/'.$slider->gambar) }}" class="d-block w-100 h-100" style="object-fit: cover;" alt="{{ $slider->judul }}">
                            <div class="position-absolute bottom-0 start-0 end-0 p-4" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                                <h3 class="text-white mb-2" style="font-family: 'Playfair Display', serif; font-size: 1.8rem;">{{ $slider->judul }}</h3>
                                @if($slider->subjudul)
                                <p class="text-white-50 mb-3">{{ $slider->subjudul }}</p>
                                @endif
                                @if($slider->tautan)
                                <a href="{{ $slider->tautan }}" class="btn" style="background: var(--sumbawa-gold); color: var(--sumbawa-dark); border-radius: 25px; padding: 8px 25px; font-weight: 600;">
                                    {{ $slider->teks_tombol ?? 'Selengkapnya' }} <i class="bi bi-arrow-right ms-2"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @if($sliders->count() > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#heroSlider" data-bs-slide="prev" style="width: 50px; height: 50px; background: rgba(0,0,0,0.5); border-radius: 50%; top: 50%; transform: translateY(-50%); left: 20px;">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroSlider" data-bs-slide="next" style="width: 50px; height: 50px; background: rgba(0,0,0,0.5); border-radius: 50%; top: 50%; transform: translateY(-50%); right: 20px;">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
                @endif
            </div>
        </div>
    </section>
    @endif

    <!-- Kategori Section -->
    <section class="section-modern" style="background: linear-gradient(180deg, white 0%, var(--sumbawa-cream) 100%);">
        <div class="container">
            <div class="section-header">
                <h2>Jelajahi Kategori</h2>
                <p>Temukan karya seni berdasarkan kategori budaya Sumbawa</p>
            </div>
            <div class="row g-3 justify-content-center">
                @forelse($kategoriUnggulan as $kategori)
                <div class="col-4 col-md-3 col-lg-2">
                    <a href="{{ route('kategori.show', $kategori->slug) }}" class="text-decoration-none">
                        <div class="text-center">
                            <div class="rounded-4 p-3 mb-2" style="background: white; box-shadow: 0 5px 20px rgba(0,0,0,0.08); transition: all 0.3s ease;"
                                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 30px rgba(168, 50, 50, 0.15)'" 
                                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 5px 20px rgba(0,0,0,0.08)'">
                                @if($kategori->ikon)
                                <i class="bi {{ $kategori->ikon }} fs-2" style="color: var(--sumbawa-red);"></i>
                                @else
                                <i class="bi bi-collection fs-2" style="color: var(--sumbawa-red);"></i>
                                @endif
                            </div>
                            <h6 class="fw-semibold small mb-1" style="color: var(--sumbawa-dark);">{{ $kategori->nama_kategori }}</h6>
                            <small class="text-muted" style="font-size: 0.75rem;">{{ $kategori->karya_seni_count }} karya</small>
                        </div>
                    </a>
                </div>
                @empty
                @foreach(['Tari Tradisional', 'Musik', 'Kerajinan', 'Lukisan', 'Ukiran', 'Tenun'] as $item)
                <div class="col-4 col-md-3 col-lg-2">
                    <div class="text-center">
                        <div class="rounded-4 p-3 mb-2" style="background: white; box-shadow: 0 5px 20px rgba(0,0,0,0.08);">
                            <i class="bi bi-palette fs-2" style="color: var(--sumbawa-red);"></i>
                        </div>
                        <h6 class="fw-semibold small">{{ $item }}</h6>
                    </div>
                </div>
                @endforeach
                @endforelse
            </div>
        </div>
    </section>

    <!-- Karya Unggulan Section -->
    <section class="section-modern" style="background: white;">
        <div class="container">
            <div class="section-header">
                <h2>Karya Unggulan</h2>
                <p>Karya-karya terbaik dari para seniman Sumbawa Besar</p>
            </div>
            <div class="row g-3">
                @forelse($karyaUnggulan as $karya)
                <div class="col-6 col-lg-3">
                    <div class="modern-card h-100">
                        <div class="card-img-wrapper" style="height: 160px;">
                            @if($karya->thumbnail_url)
                            <img src="{{ $karya->thumbnail_url }}" alt="{{ $karya->judul_karya }}">
                            @else
                            <div class="w-100 h-100 bg-secondary d-flex align-items-center justify-content-center">
                                <i class="bi bi-image fs-1 text-white"></i>
                            </div>
                            @endif
                        </div>
                        <div class="card-body" style="padding: 15px;">
                            <span class="card-category" style="font-size: 0.7rem; padding: 3px 10px;">{{ $karya->kategori?->nama_kategori }}</span>
                            <h5 class="card-title-modern" style="font-size: 1rem;">{{ Str::limit($karya->judul_karya, 30) }}</h5>
                            <p class="text-muted small mb-2 d-none d-sm-block" style="line-height: 1.5; font-size: 0.8rem;">{{ Str::limit($karya->deskripsi_singkat, 50) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted" style="font-size: 0.75rem;">
                                    <i class="bi bi-person-circle me-1"></i> {{ $karya->nama_seniman }}
                                </small>
                                <a href="{{ route('karya.show', $karya->slug) }}" class="btn btn-sm" style="background: var(--sumbawa-red); color: white; border-radius: 15px; padding: 3px 12px; font-size: 0.75rem;">
                                    Lihat
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <div class="py-5">
                        <i class="bi bi-palette fs-1 text-muted mb-3"></i>
                        <p class="text-muted">Belum ada karya yang dipublikasikan.</p>
                    </div>
                </div>
                @endforelse
            </div>
            @if($karyaUnggulan->count() > 0)
            <div class="text-center mt-4">
                <a href="{{ route('karya.index') }}" class="btn btn-outline-danger rounded-pill px-4 py-2">
                    Lihat Semua Karya <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
            @endif
        </div>
    </section>

    <!-- Seniman Unggulan Section -->
    <section class="section-modern" style="background: linear-gradient(180deg, var(--sumbawa-cream) 0%, white 100%);">
        <div class="container">
            <div class="section-header">
                <h2>Seniman Unggulan</h2>
                <p>Mengenal para seniman berbakat dari Sumbawa Besar</p>
            </div>
            <div class="row g-3 justify-content-center">
                @forelse($senimanUnggulan as $seniman)
                <div class="col-4 col-md-3 col-lg-2">
                    <a href="{{ route('seniman.show', $seniman->user_id) }}" class="text-decoration-none">
                        <div class="text-center">
                            <div class="position-relative d-inline-block mb-2">
                                @if($seniman->foto_profil)
                                <img src="{{ asset('storage/'.$seniman->foto_profil) }}" 
                                     class="rounded-circle shadow" 
                                     style="width: 80px; height: 80px; object-fit: cover; border: 3px solid white;"
                                     alt="{{ $seniman->nama_tampilan }}">
                                @else
                                <div class="rounded-circle shadow d-flex align-items-center justify-content-center" 
                                     style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--sumbawa-red), var(--sumbawa-dark-red)); border: 3px solid white;">
                                    <i class="bi bi-person-fill fs-3 text-white"></i>
                                </div>
                                @endif
                                <div class="position-absolute bottom-0 end-0 bg-white rounded-circle p-1 shadow-sm" style="width: 22px; height: 22px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-patch-check-fill" style="color: var(--sumbawa-gold); font-size: 0.7rem;"></i>
                                </div>
                            </div>
                            <h6 class="fw-bold mb-1 small" style="color: var(--sumbawa-dark);">{{ Str::limit($seniman->nama_tampilan, 15) }}</h6>
                            <small class="text-muted" style="font-size: 0.75rem;">{{ $seniman->bidang_seni_utama }}</small>
                        </div>
                    </a>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Belum ada seniman terdaftar.</p>
                </div>
                @endforelse
            </div>
            @if($senimanUnggulan->count() > 0)
            <div class="text-center mt-4">
                <a href="{{ route('seniman.index') }}" class="btn btn-outline-danger rounded-pill px-4 py-2">
                    Lihat Semua Seniman <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-4" style="background: linear-gradient(135deg, var(--sumbawa-red) 0%, var(--sumbawa-dark-red) 100%);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 text-center text-lg-start">
                    <h3 class="text-white mb-2" style="font-family: 'Playfair Display', serif; font-size: 1.5rem;">
                        Apakah Anda Seorang Seniman?
                    </h3>
                    <p class="text-white-50 mb-0 small">
                        Daftarkan karya Anda dan jadilah bagian dari komunitas seniman Sumbawa Besar
                    </p>
                </div>
                <div class="col-lg-4 text-center text-lg-end mt-3 mt-lg-0">
                    <a href="{{ route('register') }}" class="btn btn-light rounded-pill px-4 fw-semibold">
                        <i class="bi bi-person-plus me-2"></i> Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    /* Carousel Custom Styles */
    #heroSlider {
        position: relative;
    }
    
    #heroSlider .carousel-indicators {
        bottom: -40px;
    }
    
    #heroSlider .carousel-indicators button {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: var(--sumbawa-red);
        border: 2px solid transparent;
        margin: 0 5px;
        opacity: 0.3;
    }
    
    #heroSlider .carousel-indicators button.active {
        background-color: var(--sumbawa-gold);
        opacity: 1;
    }
    
    #heroSlider .carousel-control-prev,
    #heroSlider .carousel-control-next {
        width: 50px;
        height: 50px;
        background: rgba(0,0,0,0.5);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        opacity: 1;
    }
    
    #heroSlider .carousel-control-prev:hover,
    #heroSlider .carousel-control-next:hover {
        background: rgba(0,0,0,0.7);
    }
    
    @media (max-width: 768px) {
        #heroSlider .position-relative {
            height: 250px !important;
        }
        
        #heroSlider h3 {
            font-size: 1.3rem !important;
        }
        
        #heroSlider p {
            font-size: 0.85rem !important;
        }
    }
</style>
@endpush
