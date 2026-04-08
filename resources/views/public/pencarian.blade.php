@extends('layouts.public')

@section('title', 'Pencarian - Portal Karya Seniman Sumbawa Besar')

@section('content')
<section class="section-modern">
    <div class="container">
        <div class="mb-4">
            <h2 class="section-header" style="text-align: left;">
                <span style="font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700; color: var(--sumbawa-dark);">Hasil Pencarian</span>
            </h2>
            <p class="text-muted">Kata kunci: "{{ $query }}"</p>
        </div>

        <div class="row g-4">
            <!-- Karya Results -->
            <div class="col-lg-8">
                <div class="modern-card p-4 mb-4">
                    <h4 class="mb-3" style="font-family: 'Playfair Display', serif; color: var(--sumbawa-dark); border-bottom: 2px solid var(--sumbawa-gold); padding-bottom: 10px; display: inline-block;">Karya Seni ({{ $karyaResults->count() }})</h4>
                    
                    @forelse($karyaResults as $karya)
                    <div class="d-flex mb-3 pb-3 border-bottom">
                        <div class="rounded-3 overflow-hidden" style="width: 120px; height: 90px; flex-shrink: 0;">
                            @if($karya->thumbnail_url)
                            <img src="{{ $karya->thumbnail_url }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $karya->judul_karya }}">
                            @else
                            <div class="w-100 h-100 bg-secondary d-flex align-items-center justify-content-center">
                                <i class="bi bi-image fs-3 text-white"></i>
                            </div>
                            @endif
                        </div>
                        <div class="ms-3 flex-grow-1">
                            <h5 class="mb-1"><a href="{{ route('karya.show', $karya->slug) }}" class="text-decoration-none" style="color: var(--sumbawa-dark);">{{ $karya->judul_karya }}</a></h5>
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
                <div class="modern-card p-4">
                    <h4 class="mb-3" style="font-family: 'Playfair Display', serif; color: var(--sumbawa-dark); border-bottom: 2px solid var(--sumbawa-gold); padding-bottom: 10px; display: inline-block;">Seniman ({{ $senimanResults->count() }})</h4>
                    
                    @forelse($senimanResults as $seniman)
                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                        @if($seniman->foto_profil)
                        <img src="{{ asset('storage/'.$seniman->foto_profil) }}" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover; border: 2px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.1);" alt="{{ $seniman->nama_tampilan }}">
                        @else
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--sumbawa-red), var(--sumbawa-dark-red));">
                            <i class="bi bi-person-fill fs-5 text-white"></i>
                        </div>
                        @endif
                        <div class="ms-3">
                            <h6 class="mb-0"><a href="{{ route('seniman.show', $seniman->user_id) }}" class="text-decoration-none" style="color: var(--sumbawa-dark);">{{ $seniman->nama_tampilan }}</a></h6>
                            <small class="text-muted">{{ $seniman->bidang_seni_utama }}</small>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted">Tidak ada seniman yang ditemukan.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
