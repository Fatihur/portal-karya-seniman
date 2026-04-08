<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\KaryaSeni;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KaryaController extends Controller
{
    public function index(Request $request)
    {
        $query = KaryaSeni::publik()->with(['user.profilSeniman', 'kategori']);
        
        if ($request->filled('kategori')) {
            $query->whereHas('kategori', function($q) use ($request) {
                $q->where('slug', $request->kategori);
            });
        }
        
        if ($request->filled('q')) {
            $query->where(function($q) use ($request) {
                $q->where('judul_karya', 'like', '%'.$request->q.'%')
                  ->orWhere('deskripsi_singkat', 'like', '%'.$request->q.'%')
                  ->orWhereHas('user', function($userQuery) use ($request) {
                      $userQuery->where('nama', 'like', '%'.$request->q.'%');
                  });
            });
        }
        
        $karyaList = $query->latest('dipublikasikan_pada')->paginate(12);
        $kategoriList = Kategori::aktif()->orderBy('urutan')->get();
        
        return view('public.karya.index', compact('karyaList', 'kategoriList'));
    }
    
    public function show($slug)
    {
        $karya = KaryaSeni::publik()
            ->with(['user.profilSeniman', 'kategori', 'mediaKarya'])
            ->where('slug', $slug)
            ->firstOrFail();
        
        $karya->incrementViewCount();
        
        $karyaTerkait = KaryaSeni::publik()
            ->where('kategori_id', $karya->kategori_id)
            ->where('id', '!=', $karya->id)
            ->take(4)
            ->get();
        
        return view('public.karya.show', compact('karya', 'karyaTerkait'));
    }
}
