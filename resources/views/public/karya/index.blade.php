@extends('layouts.public')

@section('title', 'Daftar Karya Seni - Portal Karya Seniman Sumbawa Besar')

@section('content')
<div class="mb-4">
    <h2 class="font-display fw-bold mb-1" style="font-size: 1.75rem; color: var(--text);">Daftar Karya Seni</h2>
    <p class="text-muted mb-0">Jelajahi karya-karya seni dari para seniman Sumbawa Besar</p>
</div>

<!-- Filter -->
<div class="card border-0 mb-4" style="background: var(--bg); border-radius: var(--radius); border: 1px solid var(--border);">
    <div class="card-body p-3">
        <form action="{{ route('karya.index') }}" method="GET" class="row g-3">
            <div class="col-md-6">
                <input type="text" name="q" class="form-control" placeholder="Cari karya..." value="{{ request('q') }}" style="border-radius: var(--radius-sm);">
            </div>
            <div class="col-md-4">
                <select name="kategori" class="form-select" style="border-radius: var(--radius-sm);">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoriList as $kat)
                    <option value="{{ $kat->slug }}" {{ request('kategori') == $kat->slug ? 'selected' : '' }}>
                        {{ $kat->nama_kategori }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100" style="border-radius: var(--radius-sm); background: var(--primary); border-color: var(--primary);">Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- Karya Grid -->
<div class="row g-3">
    @forelse($karyaList as $karya)
    <div class="col-6 col-md-4 col-lg-3">
        <div class="card h-100 border-0" style="border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden; transition: transform 0.2s, box-shadow 0.2s;">
            <div class="card-img-top" style="height: 180px; overflow: hidden; position: relative;">
                @if($karya->thumbnail_url)
                <img src="{{ $karya->thumbnail_url }}" alt="{{ $karya->judul_karya }}" class="w-100 h-100" style="object-fit: cover; transition: transform 0.3s;">
                @else
                <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #e2e8f0, #f1f5f9);">
                    <i class="bi bi-image fs-1" style="color: #94a3b8;"></i>
                </div>
                @endif
            </div>
            <div class="card-body d-flex flex-column" style="padding: 15px;">
                <span class="badge mb-2 align-self-start" style="background: var(--primary-light); color: var(--primary); font-size: 0.7rem; font-weight: 600;">{{ $karya->kategori?->nama_kategori }}</span>
                <h5 class="fw-bold mb-1" style="font-size: 1rem; color: var(--text);">{{ Str::limit($karya->judul_karya, 30) }}</h5>
                <p class="text-muted small mb-3 flex-grow-1 d-none d-sm-block" style="line-height: 1.5; font-size: 0.8rem;">{{ Str::limit($karya->deskripsi_singkat, 50) }}</p>
                <div class="d-flex justify-content-between align-items-center mt-auto">
                    <small class="text-muted text-truncate me-2" style="font-size: 0.75rem; max-width: 60%;">
                        <i class="bi bi-person-circle me-1"></i> {{ $karya->nama_seniman }}
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
            <i class="bi bi-info-circle me-2"></i> Belum ada karya yang ditemukan.
        </div>
    </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $karyaList->withQueryString()->links() }}
</div>
@endsection

@push('styles')
<style>
    .card:hover .card-img-top img {
        transform: scale(1.05);
    }
    .card:hover {
        box-shadow: var(--shadow-md);
    }
</style>
@endpush
