@extends('layouts.public')

@section('title', 'Daftar Kategori - Portal Karya Seniman Sumbawa Besar')

@section('content')
<section class="section-modern">
    <div class="container">
        <div class="mb-4">
            <h2 class="section-header" style="text-align: left;">
                <span style="font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700; color: var(--sumbawa-dark);">Kategori Karya Seni</span>
            </h2>
            <p class="text-muted">Jelajahi karya seni berdasarkan kategori</p>
        </div>

        <div class="row g-3">
            @forelse($kategoriList as $kategori)
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('kategori.show', $kategori->slug) }}" class="text-decoration-none">
                    <div class="modern-card text-center p-4 h-100">
                        <div class="mb-3">
                            <i class="bi bi-collection fs-1" style="color: var(--sumbawa-red);"></i>
                        </div>
                        <h5 class="fw-semibold mb-2" style="color: var(--sumbawa-dark); font-size: 1.1rem;">{{ $kategori->nama_kategori }}</h5>
                        <p class="text-muted small mb-2" style="font-size: 0.8rem; line-height: 1.5;">{{ Str::limit($kategori->deskripsi, 60) }}</p>
                        <span class="badge bg-secondary" style="font-size: 0.75rem;">{{ $kategori->karya_seni_count }} Karya</span>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i> Belum ada kategori.
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
