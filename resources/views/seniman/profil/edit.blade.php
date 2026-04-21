@extends('layouts.seniman')

@section('title', 'Edit Profil')

@section('content')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
        <h1 class="h4 mb-0">Edit Profil Saya</h1>
        <a href="{{ route('seniman.dashboard') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row g-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form action="{{ route('seniman.profil.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap *</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                   id="nama" name="nama" value="{{ old('nama', $user->nama) }}" required>
                            @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_panggung" class="form-label">Nama Panggung</label>
                                    <input type="text" class="form-control @error('nama_panggung') is-invalid @enderror" 
                                           id="nama_panggung" name="nama_panggung" value="{{ old('nama_panggung', $profil->nama_panggung ?? '') }}">
                                    @error('nama_panggung')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nomor_hp" class="form-label">Nomor HP *</label>
                                    <input type="text" class="form-control @error('nomor_hp') is-invalid @enderror" 
                                           id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp', $user->nomor_hp) }}" required>
                                    @error('nomor_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="bidang_seni_utama" class="form-label">Bidang Seni Utama *</label>
                            <input type="text" class="form-control @error('bidang_seni_utama') is-invalid @enderror" 
                                   id="bidang_seni_utama" name="bidang_seni_utama" value="{{ old('bidang_seni_utama', $profil->bidang_seni_utama ?? '') }}" required>
                            @error('bidang_seni_utama')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="biografi" class="form-label">Biografi</label>
                            <textarea class="form-control @error('biografi') is-invalid @enderror" 
                                      id="biografi" name="biografi" rows="5">{{ old('biografi', $profil->biografi ?? '') }}</textarea>
                            @error('biografi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                           id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $profil->tanggal_lahir ?? '') }}">
                                    @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin">
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
                        
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                      id="alamat" name="alamat" rows="2">{{ old('alamat', $profil->alamat ?? '') }}</textarea>
                            @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kabupaten_kota" class="form-label">Kabupaten/Kota</label>
                                    <input type="text" class="form-control @error('kabupaten_kota') is-invalid @enderror" 
                                           id="kabupaten_kota" name="kabupaten_kota" value="{{ old('kabupaten_kota', $profil->kabupaten_kota ?? '') }}">
                                    @error('kabupaten_kota')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="provinsi" class="form-label">Provinsi</label>
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
                                <div class="mb-3">
                                    <label for="instagram" class="form-label">Instagram</label>
                                    <input type="text" class="form-control @error('instagram') is-invalid @enderror" 
                                           id="instagram" name="instagram" value="{{ old('instagram', $profil->instagram ?? '') }}">
                                    @error('instagram')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="facebook" class="form-label">Facebook</label>
                                    <input type="text" class="form-control @error('facebook') is-invalid @enderror" 
                                           id="facebook" name="facebook" value="{{ old('facebook', $profil->facebook ?? '') }}">
                                    @error('facebook')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="youtube" class="form-label">YouTube</label>
                                    <input type="text" class="form-control @error('youtube') is-invalid @enderror" 
                                           id="youtube" name="youtube" value="{{ old('youtube', $profil->youtube ?? '') }}">
                                    @error('youtube')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="situs_web" class="form-label">Website/Situs Pribadi</label>
                            <input type="text" class="form-control @error('situs_web') is-invalid @enderror" 
                                   id="situs_web" name="situs_web" value="{{ old('situs_web', $profil->situs_web ?? '') }}">
                            @error('situs_web')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="prestasi" class="form-label">Prestasi</label>
                            <textarea class="form-control @error('prestasi') is-invalid @enderror" 
                                      id="prestasi" name="prestasi" rows="3">{{ old('prestasi', $profil->prestasi ?? '') }}</textarea>
                            @error('prestasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="foto_profil" class="form-label">Foto Profil</label>
                            @if($profil->foto_profil ?? false)
                            <div class="mb-2">
                                <img src="{{ asset('storage/'.$profil->foto_profil) }}" class="img-thumbnail" style="max-height: 100px;" alt="Foto Profil">
                            </div>
                            @endif
                            <input type="file" class="form-control @error('foto_profil') is-invalid @enderror" 
                                   id="foto_profil" name="foto_profil" accept="image/*">
                            @error('foto_profil')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="foto_sampul" class="form-label">Foto Sampul/Cover</label>
                            @if($profil->foto_sampul ?? false)
                            <div class="mb-2">
                                <img src="{{ asset('storage/'.$profil->foto_sampul) }}" class="img-thumbnail" style="max-height: 150px;" alt="Foto Sampul">
                            </div>
                            @endif
                            <input type="file" class="form-control @error('foto_sampul') is-invalid @enderror" 
                                   id="foto_sampul" name="foto_sampul" accept="image/*">
                            @error('foto_sampul')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <hr>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-info border-top border-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0 text-info"><i class="bi bi-lightbulb me-2"></i>Tips Profil</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Lengkapi data diri dengan benar</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Gunakan foto profil yang jelas</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Isi biografi dengan menarik</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Tambahkan prestasi jika ada</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Sertakan media sosial aktif</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop
