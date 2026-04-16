@extends('layouts.admin')

@section('title', 'Profil Portal')

@section('content')
    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Informasi Portal</h6>
                    <a href="{{ route('admin.profil-portal.edit') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-pencil me-1"></i> Edit
                    </a>
                </div>
                <div class="card-body">
                    @if($profil)
                    <div class="table-responsive">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td class="fw-bold" style="width: 120px;">Nama Portal</td>
                                <td>{{ $profil->nama_portal }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Email</td>
                                <td>{{ $profil->email_kontak ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Telepon</td>
                                <td>{{ $profil->telepon ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Alamat</td>
                                <td>{{ $profil->alamat ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="mt-3">
                        <h6 class="fw-bold">Visi</h6>
                        <p class="text-muted">{{ $profil->visi ?? '-' }}</p>
                    </div>
                    
                    <div class="mt-3">
                        <h6 class="fw-bold">Misi</h6>
                        <p class="text-muted">{{ $profil->misi ?? '-' }}</p>
                    </div>
                    
                    <div class="mt-3">
                        <h6 class="fw-bold">Sejarah</h6>
                        <p class="text-muted">{{ $profil->sejarah ?? '-' }}</p>
                    </div>
                    @else
                    <p class="text-muted">Profil portal belum diatur. <a href="{{ route('admin.profil-portal.edit') }}">Atur sekarang</a></p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            @if($profil)
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Logo & Media</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3 text-center">
                        <label class="d-block fw-bold mb-2">Logo Portal</label>
                        <img src="{{ $profil->logo_url }}" class="img-thumbnail" style="max-height: 120px;" alt="Logo">
                    </div>
                    
                    @if($profil->instagram || $profil->facebook || $profil->youtube)
                    <div class="mb-3">
                        <label class="d-block fw-bold mb-2">Media Sosial</label>
                        <ul class="list-unstyled mb-0">
                            @if($profil->instagram)
                            <li class="mb-1"><i class="bi bi-instagram me-2 text-danger"></i> {{ $profil->instagram }}</li>
                            @endif
                            @if($profil->facebook)
                            <li class="mb-1"><i class="bi bi-facebook me-2 text-primary"></i> {{ $profil->facebook }}</li>
                            @endif
                            @if($profil->youtube)
                            <li class="mb-1"><i class="bi bi-youtube me-2 text-danger"></i> {{ $profil->youtube }}</li>
                            @endif
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
@stop
