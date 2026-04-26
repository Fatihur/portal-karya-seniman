@extends('layouts.public')

@section('title', 'Pencarian - Portal Karya Seniman Sumbawa Besar')

@section('content')
<div class="mb-4">
    <h2 class="font-display fw-bold mb-1" style="font-size: 1.75rem; color: var(--text);">Hasil Pencarian</h2>
    <p class="text-muted">Kata kunci: "{{ $query }}"</p>
</div>

<div class="row g-4">
    <!-- Karya Results -->
    <div class="col-lg-8">
        <div class="card border-0 p-4 mb-4" style="border-radius: var(--radius); box-shadow: var(--shadow); border: 1px solid var(--border);">
            <h4 class="mb-3 font-display fw-bold" style="color: var(--text); border-bottom: 2px solid var(--primary); padding-bottom: 10px; display: inline-block;">Karya Seni ({{ $karyaResults->count() }})</h4>

            @forelse($karyaResults as $karya)
            <div class="d-flex mb-3 pb-3" style="border-bottom: 1px solid var(--border);">
                <div class="rounded-3 overflow-hidden" style="width: 120px; height: 90px; flex-shrink: 0;">
                    @if($karya->thumbnail_url)
                    <img src="{{ $karya->thumbnail_url }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $karya->judul_karya }}">
                    @else
                    <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #e2e8f0, #f1f5f9);">
                        <i class="bi bi-image fs-3" style="color: #94a3b8;"></i>
                    </div>
                    @endif
                </div>
                <div class="ms-3 flex-grow-1">
                    <h5 class="mb-1"><a href="{{ route('karya.show', $karya->slug) }}" class="text-decoration-none" style="color: var(--text); font-weight: 700;">{{ $karya->judul_karya }}</a></h5>
                    <p class="text-muted mb-1 small" style="line-height: 1.5;">{{ Str::limit($karya->deskripsi_singkat, 80) }}</p>
                    <div class="d-flex align-items-center gap-2">
                        <small class="text-muted">
                            <i class="bi bi-person me-1"></i> {{ $karya->nama_seniman }}
                        </small>
                        <span class="text-muted">|</span>
                        <small class="text-muted">
                            <i class="bi bi-tag me-1"></i> {{ $karya->kategori?->nama_kategori }}
                        </small>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-muted">Tidak ada karya yang ditemukan.</p>
            @endforelse
        </div>
    </div>

    <!-- Seniman Results -->
    <div class="col-lg-4">
        <div class="card border-0 p-4" style="border-radius: var(--radius); box-shadow: var(--shadow); border: 1px solid var(--border);">
            <h4 class="mb-3 font-display fw-bold" style="color: var(--text); border-bottom: 2px solid var(--primary); padding-bottom: 10px; display: inline-block;">Seniman ({{ $senimanResults->count() }})</h4>

            @forelse($senimanResults as $seniman)
            <div class="d-flex align-items-center mb-3 pb-3" style="border-bottom: 1px solid var(--border);">
                @if($seniman->foto_profil)
                <img src="{{ asset('storage/'.$seniman->foto_profil) }}" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover; border: 2px solid white; box-shadow: var(--shadow);" alt="{{ $seniman->nama_tampilan }}">
                @else
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--primary), var(--primary-dark));">
                    <i class="bi bi-person-fill fs-5 text-white"></i>
                </div>
                @endif
                <div class="ms-3">
                    <h6 class="mb-0"><a href="{{ route('seniman.show', $seniman->user_id) }}" class="text-decoration-none" style="color: var(--text); font-weight: 700;">{{ $seniman->nama_tampilan }}</a></h6>
                    <small class="text-muted">{{ $seniman->bidang_seni_utama }}</small>
                </div>
            </div>
            @empty
            <p class="text-muted">Tidak ada seniman yang ditemukan.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
