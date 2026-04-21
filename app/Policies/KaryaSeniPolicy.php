<?php

namespace App\Policies;

use App\Enums\KaryaStatus;
use App\Models\KaryaSeni;
use App\Models\User;

class KaryaSeniPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }
    
    public function view(User $user, KaryaSeni $karyaSeni): bool
    {
        if ($user->isAdmin() && $karyaSeni->status_karya === KaryaStatus::Draft) {
            return false;
        }
        return $user->isAdmin() || $karyaSeni->user_id === $user->id;
    }
    
    public function create(User $user): bool
    {
        return $user->isSeniman();
    }
    
    public function update(User $user, KaryaSeni $karyaSeni): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $karyaSeni->user_id === $user->id
            && $karyaSeni->status_karya->canBeEditedBySeniman();
    }

    public function delete(User $user, KaryaSeni $karyaSeni): bool
    {
        if ($user->isAdmin() && $karyaSeni->status_karya === KaryaStatus::Draft) {
            return false;
        }
        
        if ($user->isAdmin()) {
            return true;
        }

        return $karyaSeni->user_id === $user->id
            && $karyaSeni->status_karya === KaryaStatus::Draft;
    }

    public function review(User $user, KaryaSeni $karyaSeni): bool
    {
        return $user->isAdmin() && $karyaSeni->status_karya === KaryaStatus::Diajukan;
    }

    public function restore(User $user, KaryaSeni $karyaSeni): bool
    {
        return $user->isAdmin();
    }
    
    public function forceDelete(User $user, KaryaSeni $karyaSeni): bool
    {
        return $user->isAdmin();
    }
}
