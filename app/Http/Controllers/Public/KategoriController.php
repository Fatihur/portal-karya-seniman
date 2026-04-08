<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoriList = Kategori::aktif()
            ->withCount(['karyaSeni' => function($query) {
                $query->where('status_karya', 'dipublikasikan');
            }])
            ->orderBy('urutan')
            ->get();
        
        return view('public.kategori.index', compact('kategoriList'));
    }
    
    public function show($slug)
    {
        $kategori = Kategori::where('slug', $slug)->firstOrFail();
        
        $karyaList = $kategori->karyaSeni()
            ->where('status_karya', 'dipublikasikan')
            ->with('user.profilSeniman')
            ->latest('dipublikasikan_pada')
            ->paginate(12);
        
        return view('public.kategori.show', compact('kategori', 'karyaList'));
    }
}
