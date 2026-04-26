@extends('layouts.public')

@section('title', $kategori->nama_kategori . ' - Portal Karya Seniman Sumbawa Besar')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: var(--primary); text-decoration: none;">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('kategori.index') }}" style="color: var(--primary); text-decoration: none;">Kategori</a></li>
            <li class="breadcrumb-item active" style="color: var(--text-muted);">{{ $kategori->nama_kategori }}</li>
        </ol>
    </nav>
    <h2 class="font-display fw-bold mb-1" style="font-size: 1.75rem; color: var(--text);">{{ $kategori->nama_kategori }}</h2>
    @if($kategori->deskripsi)
    <p class="text-muted">{{ $kategori->deskripsi }}</p>
    @endif
</div>

<!-- Karya Grid -->
<div class="row g-3">
    @forelse($karyaList as $karya)
    <div class="col-6 col-md-4 col-lg-3">
        <div class="card border-0 h-100" style="border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden; transition: transform 0.2s, box-shadow 0.2s;">
            <div class="card-img-wrapper" style="height: 180px; overflow: hidden;">
                @if($karya->thumbnail_url)
                <img src="{{ $karya->thumbnail_url }}" alt="{{ $karya->judul_karya }}" class="w-100 h-100" style="object-fit: cover; transition: transform 0.3s;">
                @else
                <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #e2e8f0, #f1f5f9);">
                    <i class="bi bi-image fs-1" style="color: #94a3b8;"></i>
                </div>
                @endif
            </div>
            <div class="card-body" style="padding: 15px;">
                <h5 class="mb-1" style="font-size: 1rem; color: var(--text); font-weight: 700;">{{ Str::limit($karya->judul_karya, 30) }}</h5>
                <p class="text-muted small mb-2 d-none d-sm-block" style="line-height: 1.5; font-size: 0.8rem;">{{ Str::limit($karya->deskripsi_singkat, 50) }}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted" style="font-size: 0.75rem;">
                        <i class="bi bi-person me-1"></i> {{ $karya->nama_seniman }}
                    </small>
                    <a href="{{ route('karya.show', $karya->slug) }}" class="btn btn-sm px-3" style="background: var(--primary); color: white; border-radius: 100px; font-size: 0.75rem; font-weight: 600;">
                        Detail
                    </a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <div class="alert alert-info border-0" style="background: #f0fdfa; color: #0f766e; border-radius: var(--radius);">
            <i class="bi bi-info-circle me-2"></i> Belum ada karya dalam kategori ini.
        </div>
    </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $karyaList->links() }}
</div>
@endsection

@push('styles')
<style>
    .card:hover .card-img-wrapper img {
        transform: scale(1.05);
    }
    .card:hover {
        box-shadow: var(--shadow-md);
    }
</style>
@endpush
