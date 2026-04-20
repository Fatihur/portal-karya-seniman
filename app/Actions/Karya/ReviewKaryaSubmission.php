<?php

namespace App\Actions\Karya;

use App\Enums\KaryaStatus;
use App\Models\KaryaSeni;
use App\Models\ReviewKarya;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ReviewKaryaSubmission
{
    public function handle(User $admin, KaryaSeni $karya, string $outcome, string $catatan): KaryaSeni
    {
        if ($karya->status_karya !== KaryaStatus::Diajukan) {
            throw ValidationException::withMessages([
                'status' => 'Karya harus berstatus diajukan sebelum direview.',
            ]);
        }

        return DB::transaction(function () use ($admin, $karya, $outcome, $catatan) {
            $statusSebelum = $karya->status_karya->value;
            $statusSesudah = match ($outcome) {
                'disetujui' => KaryaStatus::Dipublikasikan,
                'perlu_revisi' => KaryaStatus::PerluRevisi,
                'ditolak' => KaryaStatus::Ditolak,
                default => throw ValidationException::withMessages([
                    'status' => 'Status review tidak valid.',
                ]),
            };

            $payload = [
                'status_karya' => $statusSesudah->value,
                'catatan_admin_terbaru' => $catatan,
            ];

            if ($outcome === 'disetujui') {
                $payload['disetujui_pada'] = now();
                $payload['dipublikasikan_pada'] = now();
            }

            $karya->update($payload);

            ReviewKarya::create([
                'karya_seni_id' => $karya->id,
                'admin_id' => $admin->id,
                'status_sebelum' => $statusSebelum,
                'status_sesudah' => $statusSesudah->value,
                'catatan_review' => $catatan,
                'ditinjau_pada' => now(),
            ]);

            return $karya->refresh();
        });
    }
}
