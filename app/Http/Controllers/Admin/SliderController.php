<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('urutan')->get();
        return view('admin.slider.index', compact('sliders'));
    }
    
    public function create()
    {
        return view('admin.slider.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:200',
            'subjudul' => 'nullable|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'tautan' => 'nullable|string|max:255',
            'teks_tombol' => 'nullable|string|max:100',
            'urutan' => 'nullable|integer',
            'status_aktif' => 'boolean',
        ]);
        
        $validated['gambar'] = $request->file('gambar')->store('sliders', 'public');
        $validated['status_aktif'] = $request->boolean('status_aktif', true);
        
        Slider::create($validated);
        
        return redirect()->route('admin.slider.index')->with('success', 'Slider berhasil ditambahkan.');
    }
    
    public function edit(Slider $slider)
    {
        return view('admin.slider.edit', compact('slider'));
    }
    
    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:200',
            'subjudul' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'tautan' => 'nullable|string|max:255',
            'teks_tombol' => 'nullable|string|max:100',
            'urutan' => 'nullable|integer',
            'status_aktif' => 'boolean',
        ]);
        
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('sliders', 'public');
        }
        
        $validated['status_aktif'] = $request->boolean('status_aktif', true);
        
        $slider->update($validated);
        
        return redirect()->route('admin.slider.index')->with('success', 'Slider berhasil diperbarui.');
    }
    
    public function destroy(Slider $slider)
    {
        $slider->delete();
        return redirect()->route('admin.slider.index')->with('success', 'Slider berhasil dihapus.');
    }
}
