@extends('layouts.public')

@section('title', 'Daftar Kategori - Portal Karya Seniman Sumbawa Besar')

@section('content')
<div class="mb-4">
    <h2 class="font-display fw-bold mb-1" style="font-size: 1.75rem; color: var(--text);">Kategori Karya Seni</h2>
    <p class="text-muted mb-0">Jelajahi karya seni berdasarkan kategori</p>
</div>

<div class="row g-3">
    @forelse($kategoriList as $kategori)
    <div class="col-6 col-md-4 col-lg-3">
        <a href="{{ route('kategori.show', $kategori->slug) }}" class="text-decoration-none">
            <div class="card border-0 text-center p-4 h-100" style="border-radius: var(--radius); box-shadow: var(--shadow); transition: transform 0.2s, box-shadow 0.2s; border: 1px solid var(--border);">
                <div class="mb-3">
                    <i class="bi bi-collection fs-1" style="color: var(--primary);"></i>
                </div>
                <h5 class="fw-semibold mb-2" style="color: var(--text); font-size: 1.1rem;">{{ $kategori->nama_kategori }}</h5>
                <p class="text-muted small mb-2" style="font-size: 0.8rem; line-height: 1.5;">{{ Str::limit($kategori->deskripsi, 60) }}</p>
                <span class="badge" style="background: var(--primary-light); color: var(--primary); font-size: 0.75rem;">{{ $kategori->karya_seni_count }} Karya</span>
            </div>
        </a>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <div class="alert alert-info border-0" style="background: #f0fdfa; color: #0f766e; border-radius: var(--radius);">
            <i class="bi bi-info-circle me-2"></i> Belum ada kategori.
        </div>
    </div>
    @endforelse
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
