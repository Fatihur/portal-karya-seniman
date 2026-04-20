<?php

namespace Tests\Feature\Dashboard;

use App\Models\KaryaSeni;
use App\Models\Kategori;
use App\Models\User;
use App\Services\Dashboard\BuildAdminDashboardStats;
use App\Services\Dashboard\BuildSenimanDashboardStats;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardStatsServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_stats_builder_returns_expected_counts(): void
    {
        $seniman = User::factory()->seniman()->create();
        $kategori = Kategori::factory()->create();

        KaryaSeni::factory()->for($seniman)->for($kategori)->diajukan()->create();
        KaryaSeni::factory()->for($seniman)->for($kategori)->perluRevisi()->create();
        KaryaSeni::factory()->for($seniman)->for($kategori)->dipublikasikan()->create();

        $stats = app(BuildAdminDashboardStats::class)->handle();

        $this->assertSame(1, $stats['totalSeniman']);
        $this->assertSame(3, $stats['totalKarya']);
        $this->assertSame(1, $stats['karyaMenunggu']);
        $this->assertSame(1, $stats['karyaPerluRevisi']);
        $this->assertSame(1, $stats['karyaDipublikasikan']);
        $this->assertSame(1, $stats['kategoriAktif']);
    }

    public function test_seniman_dashboard_stats_builder_returns_expected_counts_for_one_artist(): void
    {
        $user = User::factory()->seniman()->create();
        $kategori = Kategori::factory()->create();

        KaryaSeni::factory()->for($user)->for($kategori)->draft()->create();
        KaryaSeni::factory()->for($user)->for($kategori)->diajukan()->create();
        KaryaSeni::factory()->for($user)->for($kategori)->dipublikasikan()->create();

        $stats = app(BuildSenimanDashboardStats::class)->handle($user);

        $this->assertSame(3, $stats['total']);
        $this->assertSame(1, $stats['draft']);
        $this->assertSame(1, $stats['diajukan']);
        $this->assertSame(0, $stats['perlu_revisi']);
        $this->assertSame(0, $stats['ditolak']);
        $this->assertSame(1, $stats['dipublikasikan']);
    }
}
