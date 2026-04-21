@extends('layouts.seniman')

@section('title', 'Daftar Karya Seni')

@section('content')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
        <h1 class="h4 mb-0">Daftar Karya Seni</h1>
        <a href="{{ route('seniman.karya.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Tambah Karya
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive-wrapper">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th width="10%">Thumbnail</th>
                            <th width="25%">Judul Karya</th>
                            <th width="15%">Kategori</th>
                            <th width="15%">Status</th>
                            <th width="15%">Tanggal</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($karyaList as $index => $karya)
                        <tr class="align-middle">
                            <td class="text-center">{{ $karyaList->firstItem() + $index }}</td>
                            <td>
                                <img src="{{ $karya->thumbnail_url }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;" alt="{{ $karya->judul_karya }}">
                            </td>
                            <td>
                                <strong class="d-block text-truncate" style="max-width: 200px;" title="{{ $karya->judul_karya }}">{{ $karya->judul_karya }}</strong>
                                @if($karya->media_karya)
                                <small class="text-muted d-block text-truncate" style="max-width: 200px;">{{ $karya->media_karya }}</small>
                                @endif
                            </td>
                            <td>{{ $karya->kategori?->nama_kategori }}</td>
                            <td>
                                <span class="badge bg-{{ $karya->status_badge_color }}">{{ $karya->status_label }}</span>
                            </td>
                            <td>{{ $karya->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('seniman.karya.edit', $karya) }}" class="btn btn-sm btn-info text-white" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    
                                    @if($karya->canBeSubmitted())
                                    <form action="{{ route('seniman.karya.ajukan', $karya) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" title="Ajukan Review" onclick="return confirm('Ajukan karya ini untuk direview oleh admin?')">
                                            <i class="bi bi-send"></i>
                                        </button>
                                    </form>
                                    @endif
                                    
                                    <form action="{{ route('seniman.karya.destroy', $karya) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus karya ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="text-muted mb-2">Belum ada karya.</div>
                                <a href="{{ route('seniman.karya.create') }}" class="btn btn-sm btn-outline-primary">Tambah Karya Sekarang</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($karyaList->hasPages())
        <div class="card-footer bg-white border-top">
            <div class="d-flex justify-content-end">
                {{ $karyaList->links() }}
            </div>
        </div>
        @endif
    </div>
@stop