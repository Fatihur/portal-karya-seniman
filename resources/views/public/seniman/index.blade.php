@extends('layouts.public')

@section('title', 'Daftar Seniman - Portal Karya Seniman Sumbawa Besar')

@section('content')
<section class="section-modern">
    <div class="container">
        <div class="mb-4">
            <h2 class="section-header" style="text-align: left;">
                <span style="font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700; color: var(--sumbawa-dark);">Daftar Seniman</span>
            </h2>
            <p class="text-muted">Para seniman budaya dari Sumbawa Besar</p>
        </div>

        <!-- Filter -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body p-3">
                <form action="{{ route('seniman.index') }}" method="GET" class="row g-3">
                    <div class="col-md-8">
                        <input type="text" name="q" class="form-control" placeholder="Cari seniman..." value="{{ request('q') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-danger w-100">Cari</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('seniman.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Seniman Grid -->
        <div class="row g-3">
            @forelse($senimanList as $seniman)
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('seniman.show', $seniman->user_id) }}" class="text-decoration-none">
                    <div class="modern-card text-center p-4 h-100">
                        @if($seniman->foto_profil)
                        <img src="{{ asset('storage/'.$seniman->foto_profil) }}" 
                             class="rounded-circle mb-3" 
                             style="width: 90px; height: 90px; object-fit: cover; border: 3px solid white; box-shadow: 0 5px 15px rgba(0,0,0,0.1);"
                             alt="{{ $seniman->nama_tampilan }}">
                        @else
                        <div class="rounded-circle mb-3 d-flex align-items-center justify-content-center mx-auto" 
                             style="width: 90px; height: 90px; background: linear-gradient(135deg, var(--sumbawa-red), var(--sumbawa-dark-red)); border: 3px solid white; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                            <i class="bi bi-person-fill fs-2 text-white"></i>
                        </div>
                        @endif
                        <h5 class="fw-semibold mb-1" style="color: var(--sumbawa-dark); font-size: 1rem;">{{ $seniman->nama_tampilan }}</h5>
                        <p class="text-muted small mb-1">{{ $seniman->bidang_seni_utama }}</p>
                        @if($seniman->kabupaten_kota)
                        <small class="text-muted" style="font-size: 0.75rem;">
                            <i class="bi bi-geo-alt me-1"></i> {{ $seniman->kabupaten_kota }}
                        </small>
                        @endif
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i> Belum ada seniman terdaftar.
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $senimanList->withQueryString()->links() }}
        </div>
    </div>
</section>
@endsection
