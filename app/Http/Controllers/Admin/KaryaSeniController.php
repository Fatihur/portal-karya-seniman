<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KaryaSeni;
use App\Models\ReviewKarya;
use Illuminate\Http\Request;

class KaryaSeniController extends Controller
{
    public function index(Request $request)
    {
        $query = KaryaSeni::with(['user.profilSeniman', 'kategori']);
        
        if ($request->filled('status')) {
            $query->where('status_karya', $request->status);
        }
        
        if ($request->filled('kategori')) {
            $query->whereHas('kategori', function($q) use ($request) {
                $q->where('slug', $request->kategori);
            });
        }
        
        if ($request->filled('q')) {
            $query->where(function($q) use ($request) {
                $q->where('judul_karya', 'like', '%'.$request->q.'%')
                  ->orWhere('deskripsi_singkat', 'like', '%'.$request->q.'%')
                  ->orWhereHas('user', function($u) use ($request) {
                      $u->where('nama', 'like', '%'.$request->q.'%');
                  });
            });
        }
        
        $karyaList = $query->latest()->paginate(15);
        $statusCounts = [
            'total' => KaryaSeni::count(),
            'draft' => KaryaSeni::where('status_karya', 'draft')->count(),
            'diajukan' => KaryaSeni::where('status_karya', 'diajukan')->count(),
            'perlu_revisi' => KaryaSeni::where('status_karya', 'perlu_revisi')->count(),
            'disetujui' => KaryaSeni::where('status_karya', 'disetujui')->count(),
            'ditolak' => KaryaSeni::where('status_karya', 'ditolak')->count(),
            'dipublikasikan' => KaryaSeni::where('status_karya', 'dipublikasikan')->count(),
        ];
        
        return view('admin.karya.index', compact('karyaList', 'statusCounts'));
    }
    
    public function show(KaryaSeni $karyaSeni)
    {
        $karyaSeni->load(['user.profilSeniman', 'kategori', 'mediaKarya', 'reviewKarya.admin']);
        
        return view('admin.karya.show', compact('karyaSeni'));
    }
    
    public function review(KaryaSeni $karyaSeni)
    {
        $karyaSeni->load(['user.profilSeniman', 'kategori', 'mediaKarya']);
        
        return view('admin.karya.review', compact('karyaSeni'));
    }
    
    public function submitReview(Request $request, KaryaSeni $karyaSeni)
    {
        $validated = $request->validate([
            'status' => 'required|in:perlu_revisi,disetujui,ditolak',
            'catatan_review' => 'required|string',
        ]);
        
        $statusSebelum = $karyaSeni->status_karya;
        
        // Update karya status
        $updateData = ['status_karya' => $validated['status']];
        
        if ($validated['status'] === 'disetujui') {
            $updateData['disetujui_pada'] = now();
            $updateData['dipublikasikan_pada'] = now();
            $updateData['status_karya'] = 'dipublikasikan';
        }
        
        $updateData['catatan_admin_terbaru'] = $validated['catatan_review'];
        $karyaSeni->update($updateData);
        
        // Create review record
        ReviewKarya::create([
            'karya_seni_id' => $karyaSeni->id,
            'admin_id' => auth()->id(),
            'status_sebelum' => $statusSebelum,
            'status_sesudah' => $updateData['status_karya'],
            'catatan_review' => $validated['catatan_review'],
            'ditinjau_pada' => now(),
        ]);
        
        return redirect()->route('admin.karya.index')->with('success', 'Review karya berhasil disimpan.');
    }
    
    public function destroy(KaryaSeni $karyaSeni)
    {
        $karyaSeni->delete();
        
        return redirect()->route('admin.karya.index')->with('success', 'Karya berhasil dihapus.');
    }
}
