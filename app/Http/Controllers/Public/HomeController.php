<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\KaryaSeni;
use App\Models\Kategori;
use App\Models\Slider;
use App\Models\KataSambutan;
use App\Models\ProfilSeniman;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::aktif()->get();
        
        $karyaUnggulan = KaryaSeni::publik()
            ->with(['user.profilSeniman', 'kategori'])
            ->latest('dipublikasikan_pada')
            ->take(8)
            ->get();
        
        $totalKarya = KaryaSeni::publik()->count();
        
        $kategoriUnggulan = Kategori::aktif()
            ->withCount(['karyaSeni' => function($query) {
                $query->where('status_karya', 'dipublikasikan');
            }])
            ->orderBy('nama_kategori')
            ->take(6)
            ->get();
        
        $senimanUnggulan = ProfilSeniman::publicVisible()
            ->whereHas('karyaPublik')
            ->with('user')
            ->take(6)
            ->get();

        $totalSeniman = ProfilSeniman::publicVisible()->count();

        return view('public.home', compact(
            'sliders',
            'karyaUnggulan',
            'kategoriUnggulan',
            'senimanUnggulan',
            'totalKarya',
            'totalSeniman'
        ));
    }
    
    public function kataSambutan()
    {
        $sambutan = KataSambutan::aktif()->first();
        return view('public.kata-sambutan', compact('sambutan'));
    }
    
    public function pencarian(Request $request)
    {
        $query = $request->get('q');
        
        $karyaResults = KaryaSeni::publik()
            ->search($query)
            ->with(['user.profilSeniman', 'kategori'])
            ->take(10)
            ->get();

        $senimanResults = ProfilSeniman::publicVisible()
            ->search($query)
            ->with('user')
            ->take(10)
            ->get();
        
        return view('public.pencarian', compact('query', 'karyaResults', 'senimanResults'));
    }
}
