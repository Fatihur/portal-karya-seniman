@extends('layouts.admin')

@section('title', 'Profil Portal')

@section('content_header')
    <h1>Profil Portal</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Portal</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.profil-portal.edit') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($profil)
                    <table class="table table-borderless">
                        <tr>
                            <td width="150"><strong>Nama Portal</strong></td>
                            <td>{{ $profil->nama_portal }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                            <td>{{ $profil->email_kontak ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Telepon</strong></td>
                            <td>{{ $profil->telepon ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Alamat</strong></td>
                            <td>{{ $profil->alamat ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Visi</strong></td>
                            <td>{{ $profil->visi ?? '-' }}</td>
                        </tr>
                    </table>
                    
                    <h5 class="mt-4">Misi</h5>
                    <p>{{ $profil->misi ?? '-' }}</p>
                    
                    <h5 class="mt-4">Sejarah</h5>
                    <p>{{ $profil->sejarah ?? '-' }}</p>
                    @else
                    <p class="text-muted">Profil portal belum diatur. <a href="{{ route('admin.profil-portal.edit') }}">Atur sekarang</a></p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            @if($profil)
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Logo & Media</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="d-block">Logo</label>
                        <img src="{{ $profil->logo_url }}" class="img-thumbnail" style="max-height: 100px;" alt="Logo">
                    </div>
                    
                    <div class="mb-3">
                        <label class="d-block">Media Sosial</label>
                        <ul class="list-unstyled">
                            @if($profil->instagram)
                            <li><i class="fab fa-instagram mr-2"></i> {{ $profil->instagram }}</li>
                            @endif
                            @if($profil->facebook)
                            <li><i class="fab fa-facebook mr-2"></i> {{ $profil->facebook }}</li>
                            @endif
                            @if($profil->youtube)
                            <li><i class="fab fa-youtube mr-2"></i> {{ $profil->youtube }}</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@stop
