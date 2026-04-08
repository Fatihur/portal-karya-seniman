<?php

namespace App\Http\Controllers\Seniman;

use App\Http\Controllers\Controller;
use App\Models\KaryaSeni;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $statistik = [
            'total' => $user->karyaSeni()->count(),
            'draft' => $user->karyaSeni()->where('status_karya', 'draft')->count(),
            'diajukan' => $user->karyaSeni()->where('status_karya', 'diajukan')->count(),
            'perlu_revisi' => $user->karyaSeni()->where('status_karya', 'perlu_revisi')->count(),
            'disetujui' => $user->karyaSeni()->where('status_karya', 'disetujui')->count(),
            'ditolak' => $user->karyaSeni()->where('status_karya', 'ditolak')->count(),
            'dipublikasikan' => $user->karyaSeni()->where('status_karya', 'dipublikasikan')->count(),
        ];
        
        $karyaTerbaru = $user->karyaSeni()
            ->with('kategori')
            ->latest()
            ->take(5)
            ->get();
        
        return view('seniman.dashboard', compact('statistik', 'karyaTerbaru'));
    }
}
