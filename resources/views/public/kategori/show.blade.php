@extends('layouts.public')

@section('title', $kategori->nama_kategori . ' - Portal Karya Seniman Sumbawa Besar')

@section('content')
<section class="section-modern">
    <div class="container">
        <div class="mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('kategori.index') }}">Kategori</a></li>
                    <li class="breadcrumb-item active">{{ $kategori->nama_kategori }}</li>
                </ol>
            </nav>
            <h2 class="section-header" style="text-align: left;">
                <span style="font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700; color: var(--sumbawa-dark);">{{ $kategori->nama_kategori }}</span>
            </h2>
            @if($kategori->deskripsi)
            <p class="text-muted">{{ $kategori->deskripsi }}</p>
            @endif
        </div>

        <!-- Karya Grid -->
        <div class="row g-3">
            @forelse($karyaList as $karya)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="modern-card h-100">
                    <div class="card-img-wrapper" style="height: 180px;">
                        @if($karya->thumbnail_url)
                        <img src="{{ $karya->thumbnail_url }}" alt="{{ $karya->judul_karya }}">
                        @else
                        <div class="w-100 h-100 bg-secondary d-flex align-items-center justify-content-center">
                            <i class="bi bi-image fs-1 text-white"></i>
                        </div>
                        @endif
                    </div>
                    <div class="card-body" style="padding: 15px;">
                        <h5 class="card-title-modern" style="font-size: 1rem;">{{ Str::limit($karya->judul_karya, 30) }}</h5>
                        <p class="text-muted small mb-2 d-none d-sm-block" style="line-height: 1.5; font-size: 0.8rem;">{{ Str::limit($karya->deskripsi_singkat, 50) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted" style="font-size: 0.75rem;">
                                <i class="bi bi-person me-1"></i> {{ $karya->nama_seniman }}
                            </small>
                            <a href="{{ route('karya.show', $karya->slug) }}" class="btn btn-sm" style="background: var(--sumbawa-red); color: white; border-radius: 15px; padding: 3px 12px; font-size: 0.75rem;">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i> Belum ada karya dalam kategori ini.
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $karyaList->links() }}
        </div>
    </div>
</section>
@endsection
