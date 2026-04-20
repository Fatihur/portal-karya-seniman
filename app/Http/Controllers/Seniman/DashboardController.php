<?php

namespace App\Http\Controllers\Seniman;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\BuildSenimanDashboardStats;

class DashboardController extends Controller
{
    public function index(BuildSenimanDashboardStats $buildSenimanDashboardStats)
    {
        $user = auth()->user();
        $statistik = $buildSenimanDashboardStats->handle($user);

        $karyaTerbaru = $user->karyaSeni()
            ->with('kategori')
            ->latest()
            ->take(5)
            ->get();

        return view('seniman.dashboard', compact('statistik', 'karyaTerbaru'));
    }
}
