<?php

namespace Tests\Feature\Public;

use App\Models\ProfilSeniman;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicArtistSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_artist_search_does_not_return_inactive_profiles_when_only_nama_panggung_matches(): void
    {
        $inactiveUser = User::factory()->seniman()->nonaktif()->create([
            'nama' => 'Seniman Bocor',
        ]);

        ProfilSeniman::factory()->for($inactiveUser)->create([
            'nama_panggung' => 'Bocor Nonaktif',
            'bidang_seni_utama' => 'Lukis',
        ]);

        $response = $this->get('/seniman?q=' . urlencode('Bocor Nonaktif'));

        $response->assertOk();
        $response->assertDontSeeText('Bocor Nonaktif');
        $response->assertDontSeeText('Seniman Bocor');
    }
}
