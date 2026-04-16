@extends('layouts.admin')

@section('title', 'Manajemen Seniman')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Seniman</h5>
            <span class="text-muted">Total: {{ $senimanList->total() }} seniman</span>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <form action="{{ route('admin.seniman.index') }}" method="GET" class="d-flex">
                        <input type="text" name="q" class="form-control" placeholder="Cari seniman..." value="{{ request('q') }}" style="max-width: 300px;">
                        <button type="submit" class="btn btn-outline-secondary ms-2">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="table-responsive-wrapper">
                <table class="table table-hover table-sm align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama</th>
                            <th class="d-none d-md-table-cell">Email</th>
                            <th class="d-none d-lg-table-cell">Bidang</th>
                            <th>Karya</th>
                            <th>Status</th>
                            <th style="width: 80px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($senimanList as $index => $user)
                        <tr>
                            <td>{{ $senimanList->firstItem() + $index }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($user->profilSeniman?->foto_profil)
                                    <img src="{{ asset('storage/' . $user->profilSeniman->foto_profil) }}" class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;" alt="{{ $user->nama }}">
                                    @else
                                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    @endif
                                    <div>
                                        {{ $user->nama }}
                                        @if($user->profilSeniman?->nama_panggung)
                                        <br><small class="text-muted">({{ $user->profilSeniman->nama_panggung }})</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="d-none d-md-table-cell small">{{ $user->email }}</td>
                            <td class="d-none d-lg-table-cell small">{{ $user->profilSeniman?->bidang_seni_utama ?? '-' }}</td>
                            <td>
                                <span class="badge bg-info">{{ $user->karya_seni_count ?? 0 }}</span>
                            </td>
                            <td>
                                @if($user->aktif)
                                <span class="badge bg-success small">Aktif</span>
                                @else
                                <span class="badge bg-danger small">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.seniman.show', $user) }}" class="btn btn-sm btn-outline-info" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">Belum ada seniman</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($senimanList->hasPages())
        <div class="card-footer">
            {{ $senimanList->withQueryString()->links() }}
        </div>
        @endif
    </div>
@stop

@push('styles')
<style>
    .table-responsive-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    .table-responsive-wrapper table {
        min-width: 500px;
    }
    
    .table-responsive-wrapper::-webkit-scrollbar {
        height: 6px;
    }
    
    .table-responsive-wrapper::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    
    .table-responsive-wrapper::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }
</style>
@endpush
