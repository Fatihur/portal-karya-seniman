<?php

namespace Tests\Feature\Factories;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FactorySmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_factory_matches_the_users_table_schema(): void
    {
        $user = User::factory()->create(['peran' => 'seniman']);

        $this->assertSame('seniman', $user->peran);
        $this->assertNotSame('', $user->nama);
    }
}
