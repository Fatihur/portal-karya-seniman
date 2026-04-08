<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KataSambutan;
use Illuminate\Http\Request;

class KataSambutanController extends Controller
{
    public function index()
    {
        $sambutanList = KataSambutan::latest()->get();
        return view('admin.kata-sambutan.index', compact('sambutanList'));
    }
    
    public function create()
    {
        return view('admin.kata-sambutan.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:200',
            'nama_tokoh' => 'required|string|max:150',
            'jabatan' => 'nullable|string|max:150',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'isi_sambutan' => 'required|string',
            'status_aktif' => 'boolean',
        ]);
        
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('sambutan', 'public');
        }
        
        $validated['status_aktif'] = $request->boolean('status_aktif', true);
        
        // Nonaktifkan sambutan lain jika ini aktif
        if ($validated['status_aktif']) {
            KataSambutan::where('status_aktif', true)->update(['status_aktif' => false]);
        }
        
        KataSambutan::create($validated);
        
        return redirect()->route('admin.kata-sambutan.index')->with('success', 'Kata sambutan berhasil ditambahkan.');
    }
    
    public function edit(KataSambutan $kataSambutan)
    {
        return view('admin.kata-sambutan.edit', compact('kataSambutan'));
    }
    
    public function update(Request $request, KataSambutan $kataSambutan)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:200',
            'nama_tokoh' => 'required|string|max:150',
            'jabatan' => 'nullable|string|max:150',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'isi_sambutan' => 'required|string',
            'status_aktif' => 'boolean',
        ]);
        
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('sambutan', 'public');
        }
        
        $validated['status_aktif'] = $request->boolean('status_aktif', true);
        
        // Nonaktifkan sambutan lain jika ini diaktifkan dan sebelumnya tidak aktif
        if ($validated['status_aktif'] && !$kataSambutan->status_aktif) {
            KataSambutan::where('status_aktif', true)->update(['status_aktif' => false]);
        }
        
        $kataSambutan->update($validated);
        
        return redirect()->route('admin.kata-sambutan.index')->with('success', 'Kata sambutan berhasil diperbarui.');
    }
    
    public function destroy(KataSambutan $kataSambutan)
    {
        $kataSambutan->delete();
        return redirect()->route('admin.kata-sambutan.index')->with('success', 'Kata sambutan berhasil dihapus.');
    }
}
