<?php

namespace App\Http\Controllers\Admin;

use App\Enums\KaryaStatus;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SenimanController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('peran', 'seniman')->with('profilSeniman');
        
        if ($request->filled('status')) {
            $query->where('status_akun', $request->status);
        }
        
        if ($request->filled('q')) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%'.$request->q.'%')
                  ->orWhere('email', 'like', '%'.$request->q.'%')
                  ->orWhereHas('profilSeniman', function($p) use ($request) {
                      $p->where('nama_panggung', 'like', '%'.$request->q.'%')
                        ->orWhere('bidang_seni_utama', 'like', '%'.$request->q.'%');
                  });
            });
        }
        
        $senimanList = $query->latest()->paginate(15);
        
        return view('admin.seniman.index', compact('senimanList'));
    }
    
    public function show(User $user)
    {
        $user->load(['profilSeniman', 'karyaSeni.kategori']);
        
        $statistik = [
            'total_karya' => $user->karyaSeni()->count(),
            'dipublikasikan' => $user->karyaSeni()->where('status_karya', KaryaStatus::Dipublikasikan->value)->count(),
            'menunggu_review' => $user->karyaSeni()->where('status_karya', KaryaStatus::Diajukan->value)->count(),
            'perlu_revisi' => $user->karyaSeni()->where('status_karya', KaryaStatus::PerluRevisi->value)->count(),
        ];
        
        return view('admin.seniman.show', compact('user', 'statistik'));
    }
    
    public function updateStatus(Request $request, User $user)
    {
        $validated = $request->validate([
            'status_akun' => 'required|in:aktif,nonaktif,diblokir',
        ]);
        
        $user->update($validated);
        
        return back()->with('success', 'Status akun seniman berhasil diperbarui.');
    }
    
    public function resetPassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'password' => 'required|min:8',
        ]);
        
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);
        
        return back()->with('success', 'Password seniman berhasil direset.');
    }
}
