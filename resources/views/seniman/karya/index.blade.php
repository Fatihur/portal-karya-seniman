@extends('layouts.seniman')

@section('title', 'Daftar Karya Seni')

@section('content')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
        <h1 class="h4 mb-0 font-display">Daftar Karya Seni</h1>
        <a href="{{ route('seniman.karya.create') }}" class="btn btn-primary" style="background: var(--primary); border-color: var(--primary); border-radius: var(--radius-sm);">
            <i class="bi bi-plus-circle me-1"></i> Tambah Karya
        </a>
    </div>

    <div class="card border-0" style="border-radius: var(--radius); box-shadow: var(--shadow);">
        <div class="card-body p-0">
            <div class="table-responsive-wrapper">
                <table class="table table-hover mb-0" style="font-size: 0.9rem;">
                    <thead style="background: var(--bg);">
                        <tr>
                            <th width="5%" class="text-center" style="padding: 12px 8px; font-weight: 600;">No</th>
                            <th width="10%" style="padding: 12px 8px; font-weight: 600;">Thumbnail</th>
                            <th width="25%" style="padding: 12px 8px; font-weight: 600;">Judul Karya</th>
                            <th width="15%" style="padding: 12px 8px; font-weight: 600;">Kategori</th>
                            <th width="15%" style="padding: 12px 8px; font-weight: 600;">Status</th>
                            <th width="15%" style="padding: 12px 8px; font-weight: 600;">Tanggal</th>
                            <th width="15%" class="text-center" style="padding: 12px 8px; font-weight: 600;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($karyaList as $index => $karya)
                        <tr class="align-middle">
                            <td class="text-center" style="padding: 12px 8px;">{{ $karyaList->firstItem() + $index }}</td>
                            <td style="padding: 12px 8px;">
                                <img src="{{ $karya->thumbnail_url }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover; border-radius: var(--radius-sm); border: none;" alt="{{ $karya->judul_karya }}">
                            </td>
                            <td style="padding: 12px 8px;">
                                <strong class="d-block text-truncate" style="max-width: 200px; color: var(--text);" title="{{ $karya->judul_karya }}">{{ $karya->judul_karya }}</strong>
                                @if($karya->media_karya)
                                <small class="text-muted d-block text-truncate" style="max-width: 200px;">{{ $karya->media_karya }}</small>
                                @endif
                            </td>
                            <td style="padding: 12px 8px;">{{ $karya->kategori?->nama_kategori }}</td>
                            <td style="padding: 12px 8px;">
                                <span class="badge" style="background: {{ $karya->status_badge_color === 'danger' ? '#fef2f2' : ($karya->status_badge_color === 'success' ? '#ecfdf5' : ($karya->status_badge_color === 'warning' ? '#fffbeb' : '#f1f5f9')) }}; color: {{ $karya->status_badge_color === 'danger' ? '#991b1b' : ($karya->status_badge_color === 'success' ? '#065f46' : ($karya->status_badge_color === 'warning' ? '#92400e' : '#334155')) }}; font-weight: 600;">{{ $karya->status_label }}</span>
                            </td>
                            <td style="padding: 12px 8px;">{{ $karya->created_at->format('d/m/Y') }}</td>
                            <td style="padding: 12px 8px;">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('seniman.karya.edit', $karya) }}" class="btn btn-sm" style="background: #e0f2fe; color: #0369a1; border: none; border-radius: 6px;" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    @if($karya->canBeSubmitted())
                                    <form action="{{ route('seniman.karya.ajukan', $karya) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm" style="background: #ecfdf5; color: #059669; border: none; border-radius: 6px;" title="Ajukan Review" onclick="return confirm('Ajukan karya ini untuk direview oleh admin?')">
                                            <i class="bi bi-send"></i>
                                        </button>
                                    </form>
                                    @endif

                                    <form action="{{ route('seniman.karya.destroy', $karya) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm" style="background: #fef2f2; color: #991b1b; border: none; border-radius: 6px;" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus karya ini?')">
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
        <div class="card-footer bg-white border-top" style="border-color: var(--border);">
            <div class="d-flex justify-content-end">
                {{ $karyaList->links() }}
            </div>
        </div>
        @endif
    </div>
@stop
