<?php

namespace Tests\Feature\Karya;

use App\Models\KaryaSeni;
use App\Models\User;
use App\Policies\KaryaSeniPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KaryaPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_review_only_submitted_karya(): void
    {
        $policy = new KaryaSeniPolicy();
        $admin = User::factory()->admin()->create();
        $submitted = KaryaSeni::factory()->diajukan()->create();
        $draft = KaryaSeni::factory()->draft()->create();

        $this->assertTrue($policy->review($admin, $submitted));
        $this->assertFalse($policy->review($admin, $draft));
    }

    public function test_owner_can_only_edit_draft_like_states(): void
    {
        $policy = new KaryaSeniPolicy();
        $owner = User::factory()->seniman()->create();

        $draft = KaryaSeni::factory()->for($owner)->draft()->create();
        $revision = KaryaSeni::factory()->for($owner)->perluRevisi()->create();
        $published = KaryaSeni::factory()->for($owner)->dipublikasikan()->create();

        $this->assertTrue($policy->update($owner, $draft));
        $this->assertTrue($policy->update($owner, $revision));
        $this->assertFalse($policy->update($owner, $published));
    }
}
