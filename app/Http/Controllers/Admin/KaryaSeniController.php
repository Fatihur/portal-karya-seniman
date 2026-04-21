<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Karya\ReviewKaryaSubmission;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubmitReviewKaryaRequest;
use App\Models\KaryaSeni;
use Illuminate\Http\Request;

class KaryaSeniController extends Controller
{
    public function index(Request $request)
    {
        $query = KaryaSeni::with(['user.profilSeniman', 'kategori'])
            ->where('status_karya', '!=', 'draft');
        
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
            'total' => KaryaSeni::where('status_karya', '!=', 'draft')->count(),
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
        $this->authorize('view', $karyaSeni);
        
        $karyaSeni->load(['user.profilSeniman', 'kategori', 'mediaKarya', 'reviewKarya.admin']);
        
        return view('admin.karya.show', ['karya' => $karyaSeni]);
    }
    
    public function review(KaryaSeni $karyaSeni)
    {
        $this->authorize('review', $karyaSeni);

        $karyaSeni->load(['user.profilSeniman', 'kategori', 'mediaKarya']);

        return view('admin.karya.review', ['karya' => $karyaSeni]);
    }

    public function submitReview(SubmitReviewKaryaRequest $request, KaryaSeni $karyaSeni, ReviewKaryaSubmission $action)
    {
        $this->authorize('review', $karyaSeni);

        $action->handle(
            $request->user(),
            $karyaSeni,
            $request->validated('status'),
            $request->validated('catatan_review'),
        );

        return redirect()->route('admin.karya.index')->with('success', 'Review karya berhasil disimpan.');
    }
    
    public function destroy(KaryaSeni $karyaSeni)
    {
        $this->authorize('delete', $karyaSeni);
        
        $karyaSeni->delete();
        
        return redirect()->route('admin.karya.index')->with('success', 'Karya berhasil dihapus.');
    }
}
