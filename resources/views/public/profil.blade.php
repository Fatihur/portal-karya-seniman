@extends('layouts.public')

@section('title', 'Profil Portal - Portal Karya Seniman Sumbawa Besar')

@section('content')
<section class="section-modern">
    <div class="container">
        <div class="mb-4">
            <h2 class="section-header" style="text-align: left;">
                <span style="font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700; color: var(--sumbawa-dark);">Profil Portal</span>
            </h2>
        </div>
        
        @if($profil)
        <div class="row">
            <div class="col-lg-8">
                <div class="modern-card p-4 mb-4">
                    @if($profil->sejarah)
                    <div class="mb-4">
                        <h4 style="font-family: 'Playfair Display', serif; color: var(--sumbawa-dark); border-bottom: 2px solid var(--sumbawa-gold); padding-bottom: 10px; display: inline-block;">Sejarah</h4>
                        <p style="line-height: 1.8; text-align: justify; color: #555;">{!! nl2br(e($profil->sejarah)) !!}</p>
                    </div>
                    @endif
                    
                    @if($profil->visi)
                    <div class="mb-4">
                        <h4 style="font-family: 'Playfair Display', serif; color: var(--sumbawa-dark); border-bottom: 2px solid var(--sumbawa-gold); padding-bottom: 10px; display: inline-block;">Visi</h4>
                        <p style="line-height: 1.8; color: #555;">{{ $profil->visi }}</p>
                    </div>
                    @endif
                    
                    @if($profil->misi)
                    <div class="mb-4">
                        <h4 style="font-family: 'Playfair Display', serif; color: var(--sumbawa-dark); border-bottom: 2px solid var(--sumbawa-gold); padding-bottom: 10px; display: inline-block;">Misi</h4>
                        <div style="line-height: 1.8; color: #555;">{!! nl2br(e($profil->misi)) !!}</div>
                    </div>
                    @endif
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="modern-card p-4">
                    <h5 class="mb-3" style="font-family: 'Playfair Display', serif; color: var(--sumbawa-dark);">Kontak Kami</h5>
                    
                    @if($profil->alamat)
                    <div class="mb-3">
                        <i class="bi bi-geo-alt text-danger me-2"></i>
                        <span>{{ $profil->alamat }}</span>
                    </div>
                    @endif
                    
                    @if($profil->email_kontak)
                    <div class="mb-3">
                        <i class="bi bi-envelope text-danger me-2"></i>
                        <a href="mailto:{{ $profil->email_kontak }}">{{ $profil->email_kontak }}</a>
                    </div>
                    @endif
                    
                    @if($profil->telepon)
                    <div class="mb-3">
                        <i class="bi bi-telephone text-danger me-2"></i>
                        <span>{{ $profil->telepon }}</span>
                    </div>
                    @endif
                    
                    <hr class="my-3">
                    
                    <h6 class="mb-2">Media Sosial</h6>
                    <div class="d-flex gap-2">
                        @if($profil->instagram)
                        <a href="https://instagram.com/{{ $profil->instagram }}" target="_blank" class="btn btn-sm btn-outline-danger rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-instagram"></i>
                        </a>
                        @endif
                        @if($profil->facebook)
                        <a href="https://facebook.com/{{ $profil->facebook }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-facebook"></i>
                        </a>
                        @endif
                        @if($profil->youtube)
                        <a href="https://youtube.com/{{ $profil->youtube }}" target="_blank" class="btn btn-sm btn-outline-danger rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-youtube"></i>
                        </a>
                        @endif
                    </div>
                </div>
                
                @if($profil->peta_embed)
                <div class="modern-card p-3 mt-3">
                    <h6 class="mb-2">Lokasi</h6>
                    <div class="ratio ratio-4x3 rounded-3 overflow-hidden">
                        {!! $profil->peta_embed !!}
                    </div>
                </div>
                @endif
            </div>
        </div>
        @else
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i> Profil portal belum tersedia.
        </div>
        @endif
    </div>
</section>
@endsection
