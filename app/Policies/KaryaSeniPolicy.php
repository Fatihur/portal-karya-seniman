<?php

namespace App\Policies;

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
        
        return $karyaSeni->user_id === $user->id && 
               in_array($karyaSeni->status_karya, ['draft', 'perlu_revisi']);
    }
    
    public function delete(User $user, KaryaSeni $karyaSeni): bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        
        return $karyaSeni->user_id === $user->id && 
               in_array($karyaSeni->status_karya, ['draft']);
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
