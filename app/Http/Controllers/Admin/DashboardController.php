<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KaryaSeni;
use App\Models\ReviewKarya;
use App\Services\Dashboard\BuildAdminDashboardStats;

class DashboardController extends Controller
{
    public function index(BuildAdminDashboardStats $buildAdminDashboardStats)
    {
        $stats = $buildAdminDashboardStats->handle();

        $karyaTerbaru = KaryaSeni::where('status_karya', '!=', 'draft')
            ->with(['user', 'kategori'])
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

        return view('admin.dashboard', array_merge($stats, [
            'karyaTerbaru' => $karyaTerbaru,
            'menungguReview' => $menungguReview,
            'reviewTerbaru' => $reviewTerbaru,
        ]));
    }
}
