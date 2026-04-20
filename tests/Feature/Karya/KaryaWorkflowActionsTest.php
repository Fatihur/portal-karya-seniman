<?php

namespace Tests\Feature\Karya;

use App\Actions\Karya\ReviewKaryaSubmission;
use App\Actions\Karya\SubmitKaryaForReview;
use App\Enums\KaryaStatus;
use App\Models\KaryaSeni;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KaryaWorkflowActionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_submit_action_marks_a_karya_as_diajukan(): void
    {
        $karya = KaryaSeni::factory()->draft()->create();

        $updated = app(SubmitKaryaForReview::class)->handle($karya);

        $this->assertSame(KaryaStatus::Diajukan, $updated->status_karya);
        $this->assertNotNull($updated->diajukan_pada);
    }

    public function test_review_action_publishes_an_approved_karya_and_records_history(): void
    {
        $admin = User::factory()->admin()->create();
        $karya = KaryaSeni::factory()->diajukan()->create();

        $updated = app(ReviewKaryaSubmission::class)->handle($admin, $karya, 'disetujui', 'Siap tayang');

        $this->assertSame(KaryaStatus::Dipublikasikan, $updated->status_karya);
        $this->assertNotNull($updated->disetujui_pada);
        $this->assertNotNull($updated->dipublikasikan_pada);

        $this->assertDatabaseHas('review_karya', [
            'karya_seni_id' => $karya->id,
            'admin_id' => $admin->id,
            'status_sebelum' => 'diajukan',
            'status_sesudah' => 'dipublikasikan',
            'catatan_review' => 'Siap tayang',
        ]);
    }
}
