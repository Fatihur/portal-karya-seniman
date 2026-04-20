<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAreaAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_protected_areas(): void
    {
        $this->get('/admin/dashboard')->assertRedirect(route('login'));
        $this->get('/dashboard-seniman')->assertRedirect(route('login'));
    }

    public function test_seniman_is_redirected_away_from_admin_area(): void
    {
        $seniman = User::factory()->seniman()->create();

        $this->actingAs($seniman)
            ->get('/admin/dashboard')
            ->assertRedirect(route('seniman.dashboard'));
    }

    public function test_admin_is_redirected_away_from_seniman_area(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get('/dashboard-seniman')
            ->assertRedirect(route('admin.dashboard'));
    }
}
