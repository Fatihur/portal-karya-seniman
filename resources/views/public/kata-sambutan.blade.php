@extends('layouts.public')

@section('title', 'Kata Sambutan - Portal Karya Seniman Sumbawa Besar')

@section('content')
<div class="mb-4">
    <h2 class="font-display fw-bold mb-1" style="font-size: 1.75rem; color: var(--text);">Kata Sambutan</h2>
</div>

@if($sambutan)
<div class="card border-0 p-4 p-md-5" style="border-radius: var(--radius); box-shadow: var(--shadow); border: 1px solid var(--border);">
    <div class="row align-items-center">
        <div class="col-md-4 text-center mb-4 mb-md-0">
            @if($sambutan->foto)
            <img src="{{ $sambutan->foto_url }}"
                 class="rounded-circle mb-3"
                 style="width: 180px; height: 180px; object-fit: cover; border: 5px solid white; box-shadow: var(--shadow-md);"
                 alt="{{ $sambutan->nama_tokoh }}">
            @else
            <div class="rounded-circle mb-3 mx-auto d-flex align-items-center justify-content-center"
                 style="width: 180px; height: 180px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border: 5px solid white; box-shadow: var(--shadow-md);">
                <i class="bi bi-person-fill fs-1 text-white"></i>
            </div>
            @endif
            <h4 class="mb-1 font-display fw-bold">{{ $sambutan->nama_tokoh }}</h4>
            @if($sambutan->jabatan)
            <p class="text-muted">{{ $sambutan->jabatan }}</p>
            @endif
        </div>
        <div class="col-md-8">
            <h3 class="mb-3 font-display fw-bold" style="color: var(--primary-dark);">{{ $sambutan->judul }}</h3>
            <div class="lead" style="line-height: 1.9; text-align: justify; color: #475569; font-size: 1.05rem;">
                {!! nl2br(e($sambutan->isi_sambutan)) !!}
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-info border-0" style="background: #f0fdfa; color: #0f766e; border-radius: var(--radius);">
    <i class="bi bi-info-circle me-2"></i> Kata sambutan belum tersedia.
</div>
@endif
@endsection
