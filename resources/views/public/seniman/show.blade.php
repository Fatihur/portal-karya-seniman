@extends('layouts.public')

@section('title', $seniman->nama_tampilan . ' - Portal Karya Seniman Sumbawa Besar')

@push('styles')
<style>
    .cover-photo {
        height: 250px;
        background: linear-gradient(135deg, #0f766e 0%, #134e4a 100%);
        border-radius: var(--radius);
        position: relative;
    }
    .profile-avatar {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid white;
        box-shadow: var(--shadow-md);
    }
    .content-card {
        background: var(--surface);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        border: 1px solid var(--border);
    }
    .btn-social {
        border-radius: var(--radius-sm);
        border: 1.5px solid var(--border);
        color: var(--text-muted);
        transition: all 0.2s;
    }
    .btn-social:hover {
        background: var(--primary-light);
        color: var(--primary);
        border-color: var(--primary);
    }
</style>
@endpush

@section('content')
<!-- Cover Photo -->
<div class="position-relative mb-4">
    <div class="cover-photo"></div>
    <div class="position-absolute" style="bottom: -50px; left: 30px;">
        @if($seniman->foto_profil)
        <img src="{{ asset('storage/'.$seniman->foto_profil) }}"
             class="profile-avatar"
             alt="{{ $seniman->nama_tampilan }}">
        @else
        <div class="profile-avatar bg-secondary d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #94a3b8, #64748b);">
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
                <h3 class="font-display fw-bold mb-1">{{ $seniman->nama_tampilan }}</h3>
                <p class="text-muted mb-3">{{ $seniman->bidang_seni_utama }}</p>

                @if($seniman->alamat || $seniman->kabupaten_kota)
                <div class="mb-2">
                    <i class="bi bi-geo-alt me-2" style="color: var(--primary);"></i>
                    <span>{{ $seniman->kabupaten_kota ?? $seniman->alamat }}</span>
                </div>
                @endif

                @if($seniman->user?->email)
                <div class="mb-2">
                    <i class="bi bi-envelope me-2" style="color: var(--primary);"></i>
                    <a href="mailto:{{ $seniman->user->email }}" style="color: var(--primary);">{{ $seniman->user->email }}</a>
                </div>
                @endif

                <hr style="border-color: var(--border);">

                <h6 class="mb-2 fw-semibold">Media Sosial</h6>
                <div class="d-flex gap-2">
                    @if($seniman->instagram)
                    <a href="https://instagram.com/{{ $seniman->instagram }}" target="_blank" class="btn btn-sm btn-social">
                        <i class="bi bi-instagram"></i>
                    </a>
                    @endif
                    @if($seniman->facebook)
                    <a href="https://facebook.com/{{ $seniman->facebook }}" target="_blank" class="btn btn-sm btn-social">
                        <i class="bi bi-facebook"></i>
                    </a>
                    @endif
                    @if($seniman->youtube)
                    <a href="https://youtube.com/{{ $seniman->youtube }}" target="_blank" class="btn btn-sm btn-social">
                        <i class="bi bi-youtube"></i>
                    </a>
                    @endif
                    @if($seniman->situs_web)
                    <a href="{{ $seniman->situs_web }}" target="_blank" class="btn btn-sm btn-social">
                        <i class="bi bi-globe"></i>
                    </a>
                    @endif
                </div>
            </div>

            @if($seniman->prestasi)
            <div class="content-card p-4">
                <h5 class="font-display fw-bold mb-3">Prestasi</h5>
                <div style="line-height: 1.8;">
                    {!! nl2br(e($seniman->prestasi)) !!}
                </div>
            </div>
            @endif
        </div>

        <!-- Bio & Karya -->
        <div class="col-lg-8">
            <div class="content-card p-4 mb-4">
                <h4 class="font-display fw-bold mb-3">Biografi</h4>
                @if($seniman->biografi)
                <div style="line-height: 1.8; text-align: justify;">
                    {!! nl2br(e($seniman->biografi)) !!}
                </div>
                @else
                <p class="text-muted">Biografi belum tersedia.</p>
                @endif
            </div>

            <h4 class="font-display fw-bold mb-3">Karya Saya</h4>
            <div class="row g-3">
                @forelse($seniman->user?->karyaSeni?->where('status_karya', 'dipublikasikan') ?? [] as $karya)
                <div class="col-md-4">
                    <a href="{{ route('karya.show', $karya->slug) }}" class="text-decoration-none">
                        <div class="card border-0 h-100" style="border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden; transition: transform 0.2s;">
                            <img src="{{ $karya->thumbnail_url }}" class="card-img w-100" style="height: 160px; object-fit: cover;" alt="{{ $karya->judul_karya }}">
                            <div class="card-body p-3">
                                <h6 class="card-title text-truncate mb-1" style="color: var(--text); font-weight: 600;">{{ $karya->judul_karya }}</h6>
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

@push('styles')
<style>
    .card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
    }
</style>
@endpush
