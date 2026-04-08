@extends('layouts.admin')

@section('title', 'Edit Profil Portal')

@section('content_header')
    <h1>Edit Profil Portal</h1>
    <a href="{{ route('admin.profil-portal.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.profil-portal.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="nama_portal">Nama Portal *</label>
                    <input type="text" class="form-control @error('nama_portal') is-invalid @enderror" 
                           id="nama_portal" name="nama_portal" value="{{ old('nama_portal', $profil?->nama_portal) }}" required>
                    @error('nama_portal')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email_kontak">Email Kontak</label>
                            <input type="email" class="form-control @error('email_kontak') is-invalid @enderror" 
                                   id="email_kontak" name="email_kontak" value="{{ old('email_kontak', $profil?->email_kontak) }}">
                            @error('email_kontak')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="telepon">Telepon</label>
                            <input type="text" class="form-control @error('telepon') is-invalid @enderror" 
                                   id="telepon" name="telepon" value="{{ old('telepon', $profil?->telepon) }}">
                            @error('telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea class="form-control @error('alamat') is-invalid @enderror" 
                              id="alamat" name="alamat" rows="2">{{ old('alamat', $profil?->alamat) }}</textarea>
                    @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="visi">Visi</label>
                    <textarea class="form-control @error('visi') is-invalid @enderror" 
                              id="visi" name="visi" rows="2">{{ old('visi', $profil?->visi) }}</textarea>
                    @error('visi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="misi">Misi</label>
                    <textarea class="form-control @error('misi') is-invalid @enderror" 
                              id="misi" name="misi" rows="4">{{ old('misi', $profil?->misi) }}</textarea>
                    @error('misi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="sejarah">Sejarah</label>
                    <textarea class="form-control @error('sejarah') is-invalid @enderror" 
                              id="sejarah" name="sejarah" rows="4">{{ old('sejarah', $profil?->sejarah) }}</textarea>
                    @error('sejarah')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="instagram">Instagram</label>
                            <input type="text" class="form-control @error('instagram') is-invalid @enderror" 
                                   id="instagram" name="instagram" value="{{ old('instagram', $profil?->instagram) }}">
                            @error('instagram')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="facebook">Facebook</label>
                            <input type="text" class="form-control @error('facebook') is-invalid @enderror" 
                                   id="facebook" name="facebook" value="{{ old('facebook', $profil?->facebook) }}">
                            @error('facebook')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="youtube">YouTube</label>
                            <input type="text" class="form-control @error('youtube') is-invalid @enderror" 
                                   id="youtube" name="youtube" value="{{ old('youtube', $profil?->youtube) }}">
                            @error('youtube')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="logo">Logo Portal</label>
                    @if($profil?->logo)
                    <div class="mb-2">
                        <img src="{{ $profil->logo_url }}" class="img-thumbnail" style="max-height: 80px;" alt="Logo">
                    </div>
                    @endif
                    <input type="file" class="form-control-file @error('logo') is-invalid @enderror" 
                           id="logo" name="logo" accept="image/*">
                    @error('logo')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="peta_embed">Embed Peta (Google Maps)</label>
                    <textarea class="form-control @error('peta_embed') is-invalid @enderror" 
                              id="peta_embed" name="peta_embed" rows="3" placeholder="Paste iframe Google Maps di sini">{{ old('peta_embed', $profil?->peta_embed) }}</textarea>
                    @error('peta_embed')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@stop
