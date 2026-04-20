<?php

namespace App\Actions\Karya;

use App\Enums\KaryaStatus;
use App\Models\KaryaSeni;
use Illuminate\Validation\ValidationException;

class SubmitKaryaForReview
{
    public function handle(KaryaSeni $karya): KaryaSeni
    {
        if (! $karya->canBeSubmitted()) {
            throw ValidationException::withMessages([
                'status' => 'Karya tidak dapat diajukan untuk review.',
            ]);
        }

        $karya->update([
            'status_karya' => KaryaStatus::Diajukan->value,
            'diajukan_pada' => now(),
        ]);

        return $karya->refresh();
    }
}
