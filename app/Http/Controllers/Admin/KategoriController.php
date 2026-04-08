<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoriList = Kategori::withCount('karyaSeni')->orderBy('urutan')->get();
        return view('admin.kategori.index', compact('kategoriList'));
    }
    
    public function create()
    {
        return view('admin.kategori.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori',
            'slug' => 'nullable|string|max:120|unique:kategori',
            'deskripsi' => 'nullable|string',
            'ikon' => 'nullable|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'urutan' => 'nullable|integer',
            'status_aktif' => 'boolean',
        ]);
        
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['nama_kategori']);
        }
        
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('kategori', 'public');
        }
        
        $validated['status_aktif'] = $request->boolean('status_aktif', true);
        
        Kategori::create($validated);
        
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }
    
    public function show(Kategori $kategori)
    {
        return view('admin.kategori.show', compact('kategori'));
    }
    
    public function edit(Kategori $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }
    
    public function update(Request $request, Kategori $kategori)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori,' . $kategori->id,
            'slug' => 'nullable|string|max:120|unique:kategori,slug,' . $kategori->id,
            'deskripsi' => 'nullable|string',
            'ikon' => 'nullable|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'urutan' => 'nullable|integer',
            'status_aktif' => 'boolean',
        ]);
        
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('kategori', 'public');
        }
        
        $validated['status_aktif'] = $request->boolean('status_aktif', true);
        
        $kategori->update($validated);
        
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }
    
    public function destroy(Kategori $kategori)
    {
        if ($kategori->karyaSeni()->count() > 0) {
            return redirect()->route('admin.kategori.index')->with('error', 'Kategori tidak dapat dihapus karena masih memiliki karya.');
        }
        
        $kategori->delete();
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
