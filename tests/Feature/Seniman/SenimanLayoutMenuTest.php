<?php

namespace Tests\Feature\Seniman;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SenimanLayoutMenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_seniman_dashboard_shows_seniman_menu_instead_of_admin_menu(): void
    {
        $seniman = User::factory()->seniman()->create();

        $response = $this->actingAs($seniman)->get(route('seniman.dashboard'));

        $response->assertOk();
        $response->assertSeeText('Menu Seniman');
        $response->assertSee(route('seniman.dashboard'), false);
        $response->assertSee(route('seniman.karya.index'), false);
        $response->assertSee(route('seniman.karya.create'), false);
        $response->assertSee(route('seniman.profil.edit'), false);
        $response->assertDontSeeText('Menu Admin');
        $response->assertDontSee(route('admin.slider.index'), false);
        $response->assertDontSee(route('admin.kata-sambutan.index'), false);
        $response->assertDontSee(route('admin.profil-portal.index'), false);
    }

    public function test_seniman_karya_create_page_renders_header_actions(): void
    {
        $seniman = User::factory()->seniman()->create();

        $response = $this->actingAs($seniman)->get(route('seniman.karya.create'));

        $response->assertOk();
        $response->assertSeeText('Tambah Karya Baru');
        $response->assertSeeText('Kembali');
        $response->assertSee(route('seniman.karya.index'), false);
    }

    public function test_seniman_dashboard_loads_legacy_stylesheet_dependencies(): void
    {
        $seniman = User::factory()->seniman()->create();

        $response = $this->actingAs($seniman)->get(route('seniman.dashboard'));

        $response->assertOk();
        $response->assertSee(asset('vendor/adminlte/dist/css/adminlte.min.css'), false);
        $response->assertSee(asset('vendor/fontawesome-free/css/all.min.css'), false);
    }

    public function test_seniman_karya_create_page_loads_legacy_stylesheet_dependencies(): void
    {
        $seniman = User::factory()->seniman()->create();

        $response = $this->actingAs($seniman)->get(route('seniman.karya.create'));

        $response->assertOk();
        $response->assertSee(asset('vendor/adminlte/dist/css/adminlte.min.css'), false);
        $response->assertSee(asset('vendor/fontawesome-free/css/all.min.css'), false);
    }
}
