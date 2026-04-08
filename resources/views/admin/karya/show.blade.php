@extends('layouts.admin')

@section('title', 'Detail Karya')

@section('content_header')
    <h1>Detail Karya</h1>
    <a href="{{ route('admin.karya.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <img src="{{ $karya->thumbnail_url }}" class="img-fluid mb-3" style="max-height: 400px; width: 100%; object-fit: contain;" alt="{{ $karya->judul_karya }}">
                    
                    <h3>{{ $karya->judul_karya }}</h3>
                    <span class="badge badge-{{ $karya->status_badge_color }} mb-3">{{ $karya->status_label }}</span>
                    
                    <h5>Deskripsi Singkat</h5>
                    <p>{{ $karya->deskripsi_singkat }}</p>
                    
                    @if($karya->deskripsi_lengkap)
                    <h5>Deskripsi Lengkap</h5>
                    <p>{!! nl2br(e($karya->deskripsi_lengkap)) !!}</p>
                    @endif
                    
                    <div class="row mt-4">
                        @if($karya->tahun_karya)
                        <div class="col-md-6">
                            <strong>Tahun:</strong> {{ $karya->tahun_karya }}
                        </div>
                        @endif
                        @if($karya->media_karya)
                        <div class="col-md-6">
                            <strong>Media:</strong> {{ $karya->media_karya }}
                        </div>
                        @endif
                        @if($karya->dimensi)
                        <div class="col-md-6">
                            <strong>Dimensi:</strong> {{ $karya->dimensi }}
                        </div>
                        @endif
                        @if($karya->lokasi_asal)
                        <div class="col-md-6">
                            <strong>Lokasi:</strong> {{ $karya->lokasi_asal }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            @if($karya->mediaKarya->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Galeri Media</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($karya->mediaKarya as $media)
                        <div class="col-md-3">
                            <img src="{{ $media->url }}" class="img-thumbnail" style="width: 100%; height: 150px; object-fit: cover;" alt="Media">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Karya</h3>
                </div>
                <div class="card-body">
                    <strong>Seniman:</strong>
                    <p class="text-muted">{{ $karya->user?->nama }}</p>
                    
                    <strong>Kategori:</strong>
                    <p class="text-muted">{{ $karya->kategori?->nama_kategori }}</p>
                    
                    <strong>Tanggal Dibuat:</strong>
                    <p class="text-muted">{{ $karya->created_at->format('d/m/Y H:i') }}</p>
                    
                    @if($karya->diajukan_pada)
                    <strong>Tanggal Diajukan:</strong>
                    <p class="text-muted">{{ $karya->diajukan_pada->format('d/m/Y H:i') }}</p>
                    @endif
                    
                    @if($karya->disetujui_pada)
                    <strong>Tanggal Disetujui:</strong>
                    <p class="text-muted">{{ $karya->disetujui_pada->format('d/m/Y H:i') }}</p>
                    @endif
                    
                    <hr>
                    
                    @if($karya->status_karya == 'diajukan')
                    <a href="{{ route('admin.karya.review', $karya) }}" class="btn btn-primary btn-block">
                        <i class="fas fa-gavel mr-1"></i> Review Karya
                    </a>
                    @endif
                    
                    @if($karya->catatan_admin_terbaru)
                    <div class="alert alert-info mt-3">
                        <strong>Catatan Terakhir:</strong><br>
                        {{ $karya->catatan_admin_terbaru }}
                    </div>
                    @endif
                </div>
            </div>
            
            @if($karya->reviewKarya->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Review</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @foreach($karya->reviewKarya as $review)
                        <li class="list-group-item">
                            <small class="text-muted">{{ $review->ditinjau_pada?->format('d/m/Y H:i') }}</small><br>
                            <strong>{{ $review->status_sebelum }} → {{ $review->status_sesudah }}</strong><br>
                            <small>{{ $review->catatan_review }}</small>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>
@stop
