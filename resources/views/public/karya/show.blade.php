@extends('layouts.public')

@section('title', $karya->judul_karya . ' - Portal Karya Seniman Sumbawa Besar')

@push('styles')
<style>
    .karya-detail-img {
        max-height: 500px;
        object-fit: contain;
        width: 100%;
        border-radius: var(--radius);
    }
    .gallery-thumbnail {
        height: 100px;
        object-fit: cover;
        cursor: pointer;
        transition: all 0.3s;
        border-radius: var(--radius-sm);
    }
    .gallery-thumbnail:hover {
        opacity: 0.8;
        transform: scale(1.02);
    }
    .content-card {
        background: var(--surface);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        border: 1px solid var(--border);
    }
    .breadcrumb-item a {
        color: var(--primary);
        text-decoration: none;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('karya.index') }}">Karya</a></li>
                <li class="breadcrumb-item active" style="color: var(--text-muted);">{{ $karya->judul_karya }}</li>
            </ol>
        </nav>

        <!-- Karya Image -->
        <div class="mb-4 text-center" style="background: var(--bg); border-radius: var(--radius); padding: 20px;">
            <a data-fslightbox="gallery" href="{{ $karya->thumbnail_url }}">
                <img src="{{ $karya->thumbnail_url }}" class="karya-detail-img" alt="{{ $karya->judul_karya }}">
            </a>
        </div>

        <!-- Gallery -->
        @if($karya->mediaKarya->count() > 0)
        <div class="mb-4">
            <h5 class="font-display fw-bold">Galeri</h5>
            <div class="row g-2">
                @foreach($karya->mediaKarya as $media)
                <div class="col-4 col-md-3 col-lg-2">
                    <a data-fslightbox="gallery" href="{{ $media->url }}">
                        <img src="{{ $media->url }}" class="gallery-thumbnail w-100" alt="Gallery">
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Karya Info -->
        <div class="content-card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <span class="badge mb-2" style="background: var(--primary-light); color: var(--primary);">{{ $karya->kategori?->nama_kategori }}</span>
                    <h2 class="font-display fw-bold">{{ $karya->judul_karya }}</h2>
                </div>
                <div class="text-end">
                    <small class="text-muted d-block">
                        <i class="bi bi-eye me-1"></i> {{ $karya->jumlah_dilihat }} dilihat
                    </small>
                    <small class="text-muted">
                        <i class="bi bi-calendar me-1"></i> {{ $karya->dipublikasikan_pada?->format('d M Y') }}
                    </small>
                </div>
            </div>

            <hr style="border-color: var(--border);">

            <h5 class="font-display fw-bold">Deskripsi</h5>
            <p>{{ $karya->deskripsi_singkat }}</p>

            @if($karya->deskripsi_lengkap)
            <h5 class="mt-4 font-display fw-bold">Detail Karya</h5>
            <div class="content-description" style="line-height: 1.8;">
                {!! nl2br(e($karya->deskripsi_lengkap)) !!}
            </div>
            @endif

            <!-- Metadata -->
            <div class="row mt-4">
                @if($karya->tahun_karya)
                <div class="col-md-4 mb-2">
                    <strong style="color: var(--primary);"><i class="bi bi-calendar3 me-2"></i>Tahun:</strong>
                    {{ $karya->tahun_karya }}
                </div>
                @endif
                @if($karya->media_karya)
                <div class="col-md-4 mb-2">
                    <strong style="color: var(--primary);"><i class="bi bi-brush me-2"></i>Media:</strong>
                    {{ $karya->media_karya }}
                </div>
                @endif
                @if($karya->dimensi)
                <div class="col-md-4 mb-2">
                    <strong style="color: var(--primary);"><i class="bi bi-rulers me-2"></i>Dimensi:</strong>
                    {{ $karya->dimensi }}
                </div>
                @endif
                @if($karya->lokasi_asal)
                <div class="col-md-4 mb-2">
                    <strong style="color: var(--primary);"><i class="bi bi-geo-alt me-2"></i>Lokasi Asal:</strong>
                    {{ $karya->lokasi_asal }}
                </div>
                @endif
            </div>
        </div>

        <!-- Karya Terkait -->
        @if($karyaTerkait->count() > 0)
        <div class="mb-4">
            <h4 class="font-display fw-bold">Karya Terkait</h4>
            <div class="row g-3">
                @foreach($karyaTerkait as $terkait)
                <div class="col-md-4">
                    <a href="{{ route('karya.show', $terkait->slug) }}" class="text-decoration-none">
                        <div class="card border-0 h-100" style="border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden;">
                            <img src="{{ $terkait->thumbnail_url }}" class="card-img w-100" style="height: 150px; object-fit: cover;" alt="{{ $terkait->judul_karya }}">
                            <div class="card-body p-3">
                                <h6 class="card-title text-truncate mb-1" style="color: var(--text); font-weight: 600;">{{ $terkait->judul_karya }}</h6>
                                <small class="text-muted">{{ $terkait->nama_seniman }}</small>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.4.1/index.min.js"></script>
@endpush
