@extends('layouts.admin')

@section('title', 'Detail Karya')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 m-0">Detail Karya</h1>
        <a href="{{ route('admin.karya.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-body">
                    <img src="{{ $karya->thumbnail_url }}" class="img-fluid rounded mb-3 w-100" style="max-height: 400px; object-fit: contain; background: #f8f9fa;" alt="{{ $karya->judul_karya }}">
                    
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <h3 class="mb-0">{{ $karya->judul_karya }}</h3>
                        <span class="badge bg-{{ $karya->status_badge_color }}">{{ $karya->status_label }}</span>
                    </div>
                    
                    <h5 class="mt-4">Deskripsi Singkat</h5>
                    <p class="text-muted">{{ $karya->deskripsi_singkat }}</p>
                    
                    @if($karya->deskripsi_lengkap)
                    <h5 class="mt-4">Deskripsi Lengkap</h5>
                    <p>{!! nl2br(e($karya->deskripsi_lengkap)) !!}</p>
                    @endif
                    
                    <div class="row g-3 mt-3 bg-light p-3 rounded">
                        @if($karya->tahun_karya)
                        <div class="col-md-6">
                            <strong><i class="bi bi-calendar me-2 text-muted"></i>Tahun:</strong> {{ $karya->tahun_karya }}
                        </div>
                        @endif
                        @if($karya->media_karya)
                        <div class="col-md-6">
                            <strong><i class="bi bi-palette me-2 text-muted"></i>Media:</strong> {{ $karya->media_karya }}
                        </div>
                        @endif
                        @if($karya->dimensi)
                        <div class="col-md-6">
                            <strong><i class="bi bi-arrows-fullscreen me-2 text-muted"></i>Dimensi:</strong> {{ $karya->dimensi }}
                        </div>
                        @endif
                        @if($karya->lokasi_asal)
                        <div class="col-md-6">
                            <strong><i class="bi bi-geo-alt me-2 text-muted"></i>Lokasi:</strong> {{ $karya->lokasi_asal }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            @if($karya->mediaKarya->count() > 0)
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-images me-2"></i>Galeri Media</h5>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        @foreach($karya->mediaKarya as $media)
                        <div class="col-6 col-md-3">
                            <img src="{{ $media->url }}" class="img-thumbnail w-100" style="height: 150px; object-fit: cover;" alt="Media">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi Karya</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">Seniman:</small>
                        <strong>{{ $karya->user?->nama }}</strong>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted d-block">Kategori:</small>
                        <strong>{{ $karya->kategori?->nama_kategori }}</strong>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted d-block">Tanggal Dibuat:</small>
                        <strong>{{ $karya->created_at->format('d F Y, H:i') }}</strong>
                    </div>
                    
                    @if($karya->diajukan_pada)
                    <div class="mb-3">
                        <small class="text-muted d-block">Tanggal Diajukan:</small>
                        <strong>{{ $karya->diajukan_pada->format('d F Y, H:i') }}</strong>
                    </div>
                    @endif
                    
                    @if($karya->disetujui_pada)
                    <div class="mb-3">
                        <small class="text-muted d-block">Tanggal Disetujui:</small>
                        <strong>{{ $karya->disetujui_pada->format('d F Y, H:i') }}</strong>
                    </div>
                    @endif
                    
                    <hr>
                    
                    @if($karya->status_karya->value == 'diajukan')
                    <div class="d-grid mb-3">
                        <a href="{{ route('admin.karya.review', $karya) }}" class="btn btn-primary">
                            <i class="bi bi-journal-check me-1"></i> Review Karya
                        </a>
                    </div>
                    @endif
                    
                    @if($karya->catatan_admin_terbaru)
                    <div class="alert alert-info mb-0">
                        <h6 class="alert-heading"><i class="bi bi-chat-left-text me-1"></i> Catatan Terakhir:</h6>
                        <small>{{ $karya->catatan_admin_terbaru }}</small>
                    </div>
                    @endif
                </div>
            </div>
            
            @if($karya->reviewKarya->count() > 0)
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Riwayat Review</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @foreach($karya->reviewKarya->sortByDesc('created_at') as $review)
                        <li class="list-group-item">
                            <div class="d-flex w-100 justify-content-between mb-1">
                                <small class="text-muted"><i class="bi bi-calendar me-1"></i> {{ $review->ditinjau_pada?->format('d/m/y H:i') }}</small>
                            </div>
                            <p class="mb-1">
                                <span class="badge bg-secondary">{{ \App\Enums\KaryaStatus::tryFrom($review->status_sebelum)?->label() ?? $review->status_sebelum }}</span> 
                                <i class="bi bi-arrow-right text-muted mx-1"></i> 
                                @php
                                    $newStatus = \App\Enums\KaryaStatus::tryFrom($review->status_sesudah);
                                @endphp
                                <span class="badge bg-{{ $newStatus?->badgeColor() ?? 'info' }}">{{ $newStatus?->label() ?? $review->status_sesudah }}</span>
                            </p>
                            @if($review->catatan_review)
                            <small class="d-block mt-2 text-muted border-start border-2 border-info ps-2">{{ $review->catatan_review }}</small>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>
@stop
