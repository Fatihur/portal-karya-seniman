@extends('layouts.admin')

@section('title', 'Edit Profil')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Edit Profil Saya</h1>
        <a href="{{ route('seniman.dashboard') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('seniman.profil.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="nama">Nama Lengkap *</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                   id="nama" name="nama" value="{{ old('nama', $user->nama) }}" required>
                            @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_panggung">Nama Panggung</label>
                                    <input type="text" class="form-control @error('nama_panggung') is-invalid @enderror" 
                                           id="nama_panggung" name="nama_panggung" value="{{ old('nama_panggung', $profil->nama_panggung ?? '') }}">
                                    @error('nama_panggung')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nomor_hp">Nomor HP *</label>
                                    <input type="text" class="form-control @error('nomor_hp') is-invalid @enderror" 
                                           id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp', $user->nomor_hp) }}" required>
                                    @error('nomor_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="bidang_seni_utama">Bidang Seni Utama *</label>
                            <input type="text" class="form-control @error('bidang_seni_utama') is-invalid @enderror" 
                                   id="bidang_seni_utama" name="bidang_seni_utama" value="{{ old('bidang_seni_utama', $profil->bidang_seni_utama ?? '') }}" required>
                            @error('bidang_seni_utama')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="biografi">Biografi</label>
                            <textarea class="form-control @error('biografi') is-invalid @enderror" 
                                      id="biografi" name="biografi" rows="5">{{ old('biografi', $profil->biografi ?? '') }}</textarea>
                            @error('biografi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                           id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $profil->tanggal_lahir ?? '') }}">
                                    @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select class="form-control @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin">
                                        <option value="">Pilih</option>
                                        <option value="laki-laki" {{ (old('jenis_kelamin', $profil->jenis_kelamin ?? '') == 'laki-laki') ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="perempuan" {{ (old('jenis_kelamin', $profil->jenis_kelamin ?? '') == 'perempuan') ? 'selected' : '' }}>Perempuan</option>
                                        <option value="lainnya" {{ (old('jenis_kelamin', $profil->jenis_kelamin ?? '') == 'lainnya') ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('jenis_kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                      id="alamat" name="alamat" rows="2">{{ old('alamat', $profil->alamat ?? '') }}</textarea>
                            @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kabupaten_kota">Kabupaten/Kota</label>
                                    <input type="text" class="form-control @error('kabupaten_kota') is-invalid @enderror" 
                                           id="kabupaten_kota" name="kabupaten_kota" value="{{ old('kabupaten_kota', $profil->kabupaten_kota ?? '') }}">
                                    @error('kabupaten_kota')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="provinsi">Provinsi</label>
                                    <input type="text" class="form-control @error('provinsi') is-invalid @enderror" 
                                           id="provinsi" name="provinsi" value="{{ old('provinsi', $profil->provinsi ?? '') }}">
                                    @error('provinsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="instagram">Instagram</label>
                                    <input type="text" class="form-control @error('instagram') is-invalid @enderror" 
                                           id="instagram" name="instagram" value="{{ old('instagram', $profil->instagram ?? '') }}">
                                    @error('instagram')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="facebook">Facebook</label>
                                    <input type="text" class="form-control @error('facebook') is-invalid @enderror" 
                                           id="facebook" name="facebook" value="{{ old('facebook', $profil->facebook ?? '') }}">
                                    @error('facebook')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="youtube">YouTube</label>
                                    <input type="text" class="form-control @error('youtube') is-invalid @enderror" 
                                           id="youtube" name="youtube" value="{{ old('youtube', $profil->youtube ?? '') }}">
                                    @error('youtube')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="situs_web">Website/Situs Pribadi</label>
                            <input type="text" class="form-control @error('situs_web') is-invalid @enderror" 
                                   id="situs_web" name="situs_web" value="{{ old('situs_web', $profil->situs_web ?? '') }}">
                            @error('situs_web')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="prestasi">Prestasi</label>
                            <textarea class="form-control @error('prestasi') is-invalid @enderror" 
                                      id="prestasi" name="prestasi" rows="3">{{ old('prestasi', $profil->prestasi ?? '') }}</textarea>
                            @error('prestasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="foto_profil">Foto Profil</label>
                            @if($profil->foto_profil ?? false)
                            <div class="mb-2">
                                <img src="{{ asset('storage/'.$profil->foto_profil) }}" class="img-thumbnail" style="max-height: 100px;" alt="Foto Profil">
                            </div>
                            @endif
                            <input type="file" class="form-control-file @error('foto_profil') is-invalid @enderror" 
                                   id="foto_profil" name="foto_profil" accept="image/*">
                            @error('foto_profil')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="foto_sampul">Foto Sampul/Cover</label>
                            @if($profil->foto_sampul ?? false)
                            <div class="mb-2">
                                <img src="{{ asset('storage/'.$profil->foto_sampul) }}" class="img-thumbnail" style="max-height: 150px;" alt="Foto Sampul">
                            </div>
                            @endif
                            <input type="file" class="form-control-file @error('foto_sampul') is-invalid @enderror" 
                                   id="foto_sampul" name="foto_sampul" accept="image/*">
                            @error('foto_sampul')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tips Profil</h3>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> Lengkapi data diri dengan benar</li>
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> Gunakan foto profil yang jelas</li>
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> Isi biografi dengan menarik</li>
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> Tambahkan prestasi jika ada</li>
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> Sertakan media sosial aktif</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop
