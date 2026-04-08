@extends('layouts.public')

@section('title', $karya->judul_karya . ' - Portal Karya Seniman Sumbawa Besar')

@push('styles')
<style>
    .karya-detail-img {
        max-height: 500px;
        object-fit: contain;
        width: 100%;
    }
    .gallery-thumbnail {
        height: 100px;
        object-fit: cover;
        cursor: pointer;
        transition: opacity 0.3s;
    }
    .gallery-thumbnail:hover {
        opacity: 0.8;
    }
    .seniman-card {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
    }
</style>
@endpush

@section('content')
<div class="row">
    <!-- Main Content -->
    <div class="col-lg-8">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('karya.index') }}">Karya</a></li>
                <li class="breadcrumb-item active">{{ $karya->judul_karya }}</li>
            </ol>
        </nav>
        
        <!-- Karya Image -->
        <div class="content-card mb-4">
            <img src="{{ $karya->thumbnail_url }}" class="karya-detail-img" alt="{{ $karya->judul_karya }}">
        </div>
        
        <!-- Gallery -->
        @if($karya->mediaKarya->count() > 0)
        <div class="mb-4">
            <h5>Galeri</h5>
            <div class="row g-2">
                @foreach($karya->mediaKarya as $media)
                <div class="col-3">
                    <img src="{{ $media->url }}" class="gallery-thumbnail w-100 rounded" alt="Gallery">
                </div>
                @endforeach
            </div>
        </div>
        @endif
        
        <!-- Karya Info -->
        <div class="content-card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <span class="badge bg-danger mb-2">{{ $karya->kategori?->nama_kategori }}</span>
                    <h2>{{ $karya->judul_karya }}</h2>
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
            
            <hr>
            
            <h5>Deskripsi</h5>
            <p>{{ $karya->deskripsi_singkat }}</p>
            
            @if($karya->deskripsi_lengkap)
            <h5 class="mt-4">Detail Karya</h5>
            <div class="content-description">
                {!! nl2br(e($karya->deskripsi_lengkap)) !!}
            </div>
            @endif
            
            <!-- Metadata -->
            <div class="row mt-4">
                @if($karya->tahun_karya)
                <div class="col-md-4 mb-2">
                    <strong><i class="bi bi-calendar3 me-2"></i>Tahun:</strong>
                    {{ $karya->tahun_karya }}
                </div>
                @endif
                @if($karya->media_karya)
                <div class="col-md-4 mb-2">
                    <strong><i class="bi bi-brush me-2"></i>Media:</strong>
                    {{ $karya->media_karya }}
                </div>
                @endif
                @if($karya->dimensi)
                <div class="col-md-4 mb-2">
                    <strong><i class="bi bi-rulers me-2"></i>Dimensi:</strong>
                    {{ $karya->dimensi }}
                </div>
                @endif
                @if($karya->lokasi_asal)
                <div class="col-md-4 mb-2">
                    <strong><i class="bi bi-geo-alt me-2"></i>Lokasi Asal:</strong>
                    {{ $karya->lokasi_asal }}
                </div>
                @endif
            </div>
        </div>
        
        <!-- Karya Terkait -->
        @if($karyaTerkait->count() > 0)
        <div class="mb-4">
            <h4>Karya Terkait</h4>
            <div class="row g-3">
                @foreach($karyaTerkait as $terkait)
                <div class="col-md-4">
                    <a href="{{ route('karya.show', $terkait->slug) }}" class="text-decoration-none">
                        <div class="content-card">
                            <img src="{{ $terkait->thumbnail_url }}" class="card-img w-100" alt="{{ $terkait->judul_karya }}">
                            <div class="card-body">
                                <h6 class="card-title text-truncate">{{ $terkait->judul_karya }}</h6>
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
    
    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Seniman Info -->
        <div class="seniman-card mb-4">
            <h5 class="mb-3">Seniman</h5>
            <div class="d-flex align-items-center mb-3">
                @if($karya->user?->profilSeniman?->foto_profil)
                <img src="{{ asset('storage/'.$karya->user->profilSeniman->foto_profil) }}" 
                     class="rounded-circle me-3" 
                     style="width: 60px; height: 60px; object-fit: cover;"
                     alt="{{ $karya->nama_seniman }}">
                @else
                <div class="rounded-circle me-3 bg-secondary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="bi bi-person-fill fs-3 text-white"></i>
                </div>
                @endif
                <div>
                    <h6 class="mb-0">{{ $karya->nama_seniman }}</h6>
                    <small class="text-muted">{{ $karya->user?->profilSeniman?->bidang_seni_utama }}</small>
                </div>
            </div>
            <a href="{{ route('seniman.show', $karya->user_id) }}" class="btn btn-outline-danger btn-sm w-100">
                Lihat Profil Seniman
            </a>
        </div>
        
        <!-- Share -->
        <div class="content-card p-3">
            <h6>Bagikan Karya</h6>
            <div class="d-flex gap-2">
                <a href="https://facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                   target="_blank" class="btn btn-primary btn-sm">
                    <i class="bi bi-facebook"></i>
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}" 
                   target="_blank" class="btn btn-info btn-sm text-white">
                    <i class="bi bi-twitter"></i>
                </a>
                <a href="https://wa.me/?text={{ urlencode($karya->judul_karya . ' - ' . request()->url()) }}" 
                   target="_blank" class="btn btn-success btn-sm">
                    <i class="bi bi-whatsapp"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
