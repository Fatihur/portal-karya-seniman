@extends('layouts.admin')

@section('title', 'Manajemen Seniman')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Manajemen Seniman</h1>
        <span class="text-muted">Total: {{ $senimanList->total() }} seniman</span>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Seniman</h3>
            <div class="card-tools">
                <form action="{{ route('admin.seniman.index') }}" method="GET" class="input-group input-group-sm" style="width: 300px;">
                    <input type="text" name="q" class="form-control" placeholder="Cari seniman..." value="{{ request('q') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Bidang Seni</th>
                        <th>Total Karya</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($senimanList as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            {{ $user->nama }}
                            @if($user->profilSeniman?->nama_panggung)
                            <br><small class="text-muted">({{ $user->profilSeniman->nama_panggung }})</small>
                            @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->profilSeniman?->bidang_seni_utama ?? '-' }}</td>
                        <td>{{ $user->karyaSeni()->count() }}</td>
                        <td>
                            @if($user->status_akun == 'aktif')
                            <span class="badge badge-success">Aktif</span>
                            @elseif($user->status_akun == 'nonaktif')
                            <span class="badge badge-warning">Nonaktif</span>
                            @else
                            <span class="badge badge-danger">Diblokir</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.seniman.show', $user) }}" class="btn btn-sm btn-info" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada seniman terdaftar</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $senimanList->withQueryString()->links() }}
        </div>
    </div>
@stop
