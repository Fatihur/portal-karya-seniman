<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ProfilSeniman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
    
    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:150',
            'nama_panggung' => 'nullable|string|max:150',
            'email' => 'required|email|unique:users,email|max:150',
            'nomor_hp' => 'required|string|max:30',
            'bidang_seni_utama' => 'required|string|max:100',
            'alamat' => 'nullable|string',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);
        
        $user = User::create([
            'nama' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'nomor_hp' => $validated['nomor_hp'],
            'password' => Hash::make($validated['password']),
            'peran' => 'seniman',
            'status_akun' => 'aktif',
        ]);
        
        ProfilSeniman::create([
            'user_id' => $user->id,
            'nama_panggung' => $validated['nama_panggung'],
            'bidang_seni_utama' => $validated['bidang_seni_utama'],
            'alamat' => $validated['alamat'] ?? null,
        ]);
        
        Auth::login($user);
        
        return redirect()->route('seniman.dashboard')->with('success', 'Registrasi berhasil! Selamat datang di Portal Karya Seniman.');
    }
}
