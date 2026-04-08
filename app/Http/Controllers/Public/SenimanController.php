<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ProfilSeniman;
use App\Models\User;
use Illuminate\Http\Request;

class SenimanController extends Controller
{
    public function index(Request $request)
    {
        $query = ProfilSeniman::whereHas('user', function($q) {
            $q->where('status_akun', 'aktif')
              ->where('peran', 'seniman');
        })->with('user');
        
        if ($request->filled('bidang')) {
            $query->where('bidang_seni_utama', $request->bidang);
        }
        
        if ($request->filled('q')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('nama', 'like', '%'.$request->q.'%');
            })->orWhere('nama_panggung', 'like', '%'.$request->q.'%');
        }
        
        $senimanList = $query->paginate(12);
        
        $bidangList = ProfilSeniman::select('bidang_seni_utama')
            ->distinct()
            ->pluck('bidang_seni_utama');
        
        return view('public.seniman.index', compact('senimanList', 'bidangList'));
    }
    
    public function show($id)
    {
        $seniman = ProfilSeniman::with(['user', 'user.karyaSeni' => function($query) {
            $query->where('status_karya', 'dipublikasikan');
        }])->where('user_id', $id)->firstOrFail();
        
        return view('public.seniman.show', compact('seniman'));
    }
}
