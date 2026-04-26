@extends('layouts.public')

@section('title', 'Daftar Seniman - Portal Karya Seniman Sumbawa Besar')

@section('content')
<div class="mb-4">
    <h2 class="font-display fw-bold mb-1" style="font-size: 1.75rem; color: var(--text);">Daftar Seniman</h2>
    <p class="text-muted mb-0">Para seniman budaya dari Sumbawa Besar</p>
</div>

<!-- Filter -->
<div class="card border-0 mb-4" style="background: var(--bg); border-radius: var(--radius); border: 1px solid var(--border);">
    <div class="card-body p-3">
        <form action="{{ route('seniman.index') }}" method="GET" class="row g-3">
            <div class="col-md-8">
                <input type="text" name="q" class="form-control" placeholder="Cari seniman..." value="{{ request('q') }}" style="border-radius: var(--radius-sm);">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100" style="border-radius: var(--radius-sm); background: var(--primary); border-color: var(--primary);">Cari</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('seniman.index') }}" class="btn btn-outline-secondary w-100" style="border-radius: var(--radius-sm);">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Seniman Grid -->
<div class="row g-3">
    @forelse($senimanList as $seniman)
    <div class="col-6 col-md-4 col-lg-3">
        <a href="{{ route('seniman.show', $seniman->user_id) }}" class="text-decoration-none">
            <div class="card border-0 text-center p-4 h-100" style="border-radius: var(--radius); box-shadow: var(--shadow); transition: transform 0.2s, box-shadow 0.2s; border: 1px solid var(--border);">
                @if($seniman->foto_profil)
                <img src="{{ asset('storage/'.$seniman->foto_profil) }}"
                     class="rounded-circle mb-3 mx-auto"
                     style="width: 90px; height: 90px; object-fit: cover; border: 3px solid white; box-shadow: 0 5px 15px rgba(0,0,0,0.1);"
                     alt="{{ $seniman->nama_tampilan }}">
                @else
                <div class="rounded-circle mb-3 d-flex align-items-center justify-content-center mx-auto"
                     style="width: 90px; height: 90px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border: 3px solid white; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                    <i class="bi bi-person-fill fs-2 text-white"></i>
                </div>
                @endif
                <h5 class="fw-semibold mb-1" style="color: var(--text); font-size: 1rem;">{{ $seniman->nama_tampilan }}</h5>
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
        <div class="alert alert-info border-0" style="background: #f0fdfa; color: #0f766e; border-radius: var(--radius);">
            <i class="bi bi-info-circle me-2"></i> Belum ada seniman terdaftar.
        </div>
    </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $senimanList->withQueryString()->links() }}
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
