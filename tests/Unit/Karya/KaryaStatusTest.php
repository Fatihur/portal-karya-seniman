<?php

namespace Tests\Unit\Karya;

use App\Enums\KaryaStatus;
use PHPUnit\Framework\TestCase;

class KaryaStatusTest extends TestCase
{
    public function test_editable_and_submittable_states_are_centralized(): void
    {
        $this->assertTrue(KaryaStatus::Draft->canBeEditedBySeniman());
        $this->assertTrue(KaryaStatus::PerluRevisi->canBeSubmittedBySeniman());
        $this->assertFalse(KaryaStatus::Dipublikasikan->canBeEditedBySeniman());
        $this->assertSame(['perlu_revisi', 'disetujui', 'ditolak'], KaryaStatus::reviewOutcomes());
        $this->assertSame('primary', KaryaStatus::Dipublikasikan->badgeColor());
    }
}
