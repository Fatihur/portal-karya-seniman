<?php

namespace App\Http\Controllers\Seniman;

use App\Http\Controllers\Controller;
use App\Models\ProfilSeniman;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        $profil = $user->profilSeniman ?? new ProfilSeniman();
        $kategoriList = Kategori::aktif()->get();
        
        return view('seniman.profil.edit', compact('user', 'profil', 'kategoriList'));
    }
    
    public function update(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'nama' => 'required|string|max:150',
            'nama_panggung' => 'nullable|string|max:150',
            'nomor_hp' => 'required|string|max:30',
            'biografi' => 'nullable|string',
            'bidang_seni_utama' => 'required|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan,lainnya',
            'alamat' => 'nullable|string',
            'kabupaten_kota' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'instagram' => 'nullable|string|max:150',
            'facebook' => 'nullable|string|max:150',
            'youtube' => 'nullable|string|max:150',
            'situs_web' => 'nullable|string|max:150',
            'prestasi' => 'nullable|string',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'foto_sampul' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);
        
        // Update user
        $user->update([
            'nama' => $validated['nama'],
            'nomor_hp' => $validated['nomor_hp'],
        ]);
        
        // Handle file uploads
        $profilData = [
            'nama_panggung' => $validated['nama_panggung'],
            'biografi' => $validated['biografi'],
            'bidang_seni_utama' => $validated['bidang_seni_utama'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'alamat' => $validated['alamat'],
            'kabupaten_kota' => $validated['kabupaten_kota'],
            'provinsi' => $validated['provinsi'],
            'instagram' => $validated['instagram'],
            'facebook' => $validated['facebook'],
            'youtube' => $validated['youtube'],
            'situs_web' => $validated['situs_web'],
            'prestasi' => $validated['prestasi'],
        ];
        
        if ($request->hasFile('foto_profil')) {
            $profilData['foto_profil'] = $request->file('foto_profil')->store('seniman/profil', 'public');
        }
        
        if ($request->hasFile('foto_sampul')) {
            $profilData['foto_sampul'] = $request->file('foto_sampul')->store('seniman/sampul', 'public');
        }
        
        ProfilSeniman::updateOrCreate(
            ['user_id' => $user->id],
            $profilData
        );
        
        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
