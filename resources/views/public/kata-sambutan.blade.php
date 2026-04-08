@extends('layouts.public')

@section('title', 'Kata Sambutan - Portal Karya Seniman Sumbawa Besar')

@section('content')
<section class="section-modern">
    <div class="container">
        <div class="mb-4">
            <h2 class="section-header" style="text-align: left;">
                <span style="font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700; color: var(--sumbawa-dark);">Kata Sambutan</span>
            </h2>
        </div>
        
        @if($sambutan)
        <div class="modern-card p-4 p-md-5">
            <div class="row align-items-center">
                <div class="col-md-4 text-center mb-4 mb-md-0">
                    @if($sambutan->foto)
                    <img src="{{ $sambutan->foto_url }}" 
                         class="rounded-circle mb-3 shadow" 
                         style="width: 180px; height: 180px; object-fit: cover; border: 5px solid white; box-shadow: 0 10px 30px rgba(0,0,0,0.1);"
                         alt="{{ $sambutan->nama_tokoh }}">
                    @else
                    <div class="rounded-circle mb-3 mx-auto d-flex align-items-center justify-content-center" 
                         style="width: 180px; height: 180px; background: linear-gradient(135deg, var(--sumbawa-red), var(--sumbawa-dark-red)); border: 5px solid white; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                        <i class="bi bi-person-fill fs-1 text-white"></i>
                    </div>
                    @endif
                    <h4 class="mb-1" style="font-family: 'Playfair Display', serif;">{{ $sambutan->nama_tokoh }}</h4>
                    @if($sambutan->jabatan)
                    <p class="text-muted">{{ $sambutan->jabatan }}</p>
                    @endif
                </div>
                <div class="col-md-8">
                    <h3 class="mb-3" style="font-family: 'Playfair Display', serif; color: var(--sumbawa-dark);">{{ $sambutan->judul }}</h3>
                    <div class="lead" style="line-height: 1.9; text-align: justify; color: #555; font-size: 1.1rem;">
                        {!! nl2br(e($sambutan->isi_sambutan)) !!}
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i> Kata sambutan belum tersedia.
        </div>
        @endif
    </div>
</section>
@endsection
