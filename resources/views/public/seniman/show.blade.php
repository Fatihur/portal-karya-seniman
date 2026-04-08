@extends('layouts.public')

@section('title', $seniman->nama_tampilan . ' - Portal Karya Seniman Sumbawa Besar')

@section('content')
<!-- Cover Photo -->
<div class="position-relative mb-4">
    <div style="height: 250px; background: linear-gradient(135deg, #B83B3B 0%, #8B2C2C 100%); border-radius: 10px;"></div>
    <div class="position-absolute" style="bottom: -50px; left: 30px;">
        @if($seniman->foto_profil)
        <img src="{{ asset('storage/'.$seniman->foto_profil) }}" 
             class="rounded-circle border border-4 border-white" 
             style="width: 150px; height: 150px; object-fit: cover;"
             alt="{{ $seniman->nama_tampilan }}">
        @else
        <div class="rounded-circle border border-4 border-white bg-secondary d-flex align-items-center justify-content-center" style="width: 150px; height: 150px;">
            <i class="bi bi-person-fill fs-1 text-white"></i>
        </div>
        @endif
    </div>
</div>

<div class="mt-5 pt-3">
    <div class="row">
        <!-- Profile Info -->
        <div class="col-lg-4">
            <div class="content-card p-4 mb-4">
                <h3 class="mb-1">{{ $seniman->nama_tampilan }}</h3>
                <p class="text-muted mb-3">{{ $seniman->bidang_seni_utama }}</p>
                
                @if($seniman->alamat || $seniman->kabupaten_kota)
                <div class="mb-2">
                    <i class="bi bi-geo-alt text-danger me-2"></i>
                    <span>{{ $seniman->kabupaten_kota ?? $seniman->alamat }}</span>
                </div>
                @endif
                
                @if($seniman->user?->email)
                <div class="mb-2">
                    <i class="bi bi-envelope text-danger me-2"></i>
                    <a href="mailto:{{ $seniman->user->email }}">{{ $seniman->user->email }}</a>
                </div>
                @endif
                
                <hr>
                
                <h6 class="mb-2">Media Sosial</h6>
                <div class="d-flex gap-2">
                    @if($seniman->instagram)
                    <a href="https://instagram.com/{{ $seniman->instagram }}" target="_blank" class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-instagram"></i>
                    </a>
                    @endif
                    @if($seniman->facebook)
                    <a href="https://facebook.com/{{ $seniman->facebook }}" target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-facebook"></i>
                    </a>
                    @endif
                    @if($seniman->youtube)
                    <a href="https://youtube.com/{{ $seniman->youtube }}" target="_blank" class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-youtube"></i>
                    </a>
                    @endif
                    @if($seniman->situs_web)
                    <a href="{{ $seniman->situs_web }}" target="_blank" class="btn btn-sm btn-outline-dark">
                        <i class="bi bi-globe"></i>
                    </a>
                    @endif
                </div>
            </div>
            
            @if($seniman->prestasi)
            <div class="content-card p-4">
                <h5 class="mb-3">Prestasi</h5>
                <div style="line-height: 1.8;">
                    {!! nl2br(e($seniman->prestasi)) !!}
                </div>
            </div>
            @endif
        </div>
        
        <!-- Bio & Karya -->
        <div class="col-lg-8">
            <div class="content-card p-4 mb-4">
                <h4 class="mb-3">Biografi</h4>
                @if($seniman->biografi)
                <div style="line-height: 1.8; text-align: justify;">
                    {!! nl2br(e($seniman->biografi)) !!}
                </div>
                @else
                <p class="text-muted">Biografi belum tersedia.</p>
                @endif
            </div>
            
            <h4 class="mb-3">Karya Saya</h4>
            <div class="row g-3">
                @forelse($seniman->user?->karyaSeni?->where('status_karya', 'dipublikasikan') ?? [] as $karya)
                <div class="col-md-4">
                    <a href="{{ route('karya.show', $karya->slug) }}" class="text-decoration-none">
                        <div class="content-card h-100">
                            <img src="{{ $karya->thumbnail_url }}" class="card-img w-100" alt="{{ $karya->judul_karya }}">
                            <div class="card-body">
                                <h6 class="card-title text-truncate">{{ $karya->judul_karya }}</h6>
                                <small class="text-muted">{{ $karya->kategori?->nama_kategori }}</small>
                            </div>
                        </div>
                    </a>
                </div>
                @empty
                <div class="col-12">
                    <p class="text-muted">Belum ada karya yang dipublikasikan.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
