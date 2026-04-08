<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KaryaSeni;
use App\Models\User;
use App\Models\Kategori;
use App\Models\ReviewKarya;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSeniman = User::where('peran', 'seniman')->where('status_akun', 'aktif')->count();
        $totalKarya = KaryaSeni::count();
        $karyaMenunggu = KaryaSeni::where('status_karya', 'diajukan')->count();
        $karyaPerluRevisi = KaryaSeni::where('status_karya', 'perlu_revisi')->count();
        $karyaDipublikasikan = KaryaSeni::where('status_karya', 'dipublikasikan')->count();
        $kategoriAktif = Kategori::where('status_aktif', true)->count();
        
        $karyaTerbaru = KaryaSeni::with(['user', 'kategori'])
            ->latest()
            ->take(5)
            ->get();
        
        $menungguReview = KaryaSeni::where('status_karya', 'diajukan')
            ->with(['user', 'kategori'])
            ->latest('diajukan_pada')
            ->take(5)
            ->get();
        
        $reviewTerbaru = ReviewKarya::with(['karyaSeni', 'admin'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalSeniman',
            'totalKarya',
            'karyaMenunggu',
            'karyaPerluRevisi',
            'karyaDipublikasikan',
            'kategoriAktif',
            'karyaTerbaru',
            'menungguReview',
            'reviewTerbaru'
        ));
    }
}
