<?php

namespace App\Services\Dashboard;

use App\Enums\KaryaStatus;
use App\Models\User;

class BuildSenimanDashboardStats
{
    public function handle(User $user): array
    {
        return [
            'total' => $user->karyaSeni()->count(),
            'draft' => $user->karyaSeni()->where('status_karya', KaryaStatus::Draft->value)->count(),
            'diajukan' => $user->karyaSeni()->where('status_karya', KaryaStatus::Diajukan->value)->count(),
            'perlu_revisi' => $user->karyaSeni()->where('status_karya', KaryaStatus::PerluRevisi->value)->count(),
            'ditolak' => $user->karyaSeni()->where('status_karya', KaryaStatus::Ditolak->value)->count(),
            'dipublikasikan' => $user->karyaSeni()->where('status_karya', KaryaStatus::Dipublikasikan->value)->count(),
        ];
    }
}
