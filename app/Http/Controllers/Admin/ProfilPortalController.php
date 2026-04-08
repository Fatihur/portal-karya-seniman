<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilPortal;
use Illuminate\Http\Request;

class ProfilPortalController extends Controller
{
    public function index()
    {
        $profil = ProfilPortal::first();
        return view('admin.profil-portal.index', compact('profil'));
    }
    
    public function edit()
    {
        $profil = ProfilPortal::first();
        return view('admin.profil-portal.edit', compact('profil'));
    }
    
    public function update(Request $request)
    {
        $validated = $request->validate([
            'nama_portal' => 'required|string|max:200',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024',
            'sejarah' => 'nullable|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'alamat' => 'nullable|string',
            'email_kontak' => 'nullable|email|max:150',
            'telepon' => 'nullable|string|max:30',
            'peta_embed' => 'nullable|string',
            'instagram' => 'nullable|string|max:150',
            'facebook' => 'nullable|string|max:150',
            'youtube' => 'nullable|string|max:150',
        ]);
        
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('profil', 'public');
        }
        
        if ($request->hasFile('favicon')) {
            $validated['favicon'] = $request->file('favicon')->store('profil', 'public');
        }
        
        $profil = ProfilPortal::first();
        
        if ($profil) {
            $profil->update($validated);
        } else {
            ProfilPortal::create($validated);
        }
        
        return redirect()->route('admin.profil-portal.index')->with('success', 'Profil portal berhasil diperbarui.');
    }
}
