<?php

namespace App\Http\Controllers\Seniman;

use App\Http\Controllers\Controller;
use App\Models\KaryaSeni;
use App\Models\Kategori;
use App\Models\MediaKarya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KaryaSeniController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $karyaList = $user->karyaSeni()->with('kategori')->latest()->paginate(10);
        
        return view('seniman.karya.index', compact('karyaList'));
    }
    
    public function create()
    {
        $kategoriList = Kategori::aktif()->orderBy('urutan')->get();
        return view('seniman.karya.create', compact('kategoriList'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_karya' => 'required|string|max:200',
            'kategori_id' => 'required|exists:kategori,id',
            'deskripsi_singkat' => 'required|string',
            'deskripsi_lengkap' => 'nullable|string',
            'tahun_karya' => 'nullable|string|max:20',
            'media_karya' => 'nullable|string|max:150',
            'dimensi' => 'nullable|string|max:100',
            'lokasi_asal' => 'nullable|string|max:150',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'file_media.*' => 'nullable|file|max:10240',
            'catatan_seniman' => 'nullable|string',
        ]);
        
        // Store thumbnail
        $thumbnailPath = $request->file('thumbnail')->store('karya/thumbnails', 'public');
        
        $karya = KaryaSeni::create([
            'user_id' => auth()->id(),
            'kategori_id' => $validated['kategori_id'],
            'judul_karya' => $validated['judul_karya'],
            'slug' => Str::slug($validated['judul_karya']) . '-' . uniqid(),
            'deskripsi_singkat' => $validated['deskripsi_singkat'],
            'deskripsi_lengkap' => $validated['deskripsi_lengkap'],
            'tahun_karya' => $validated['tahun_karya'],
            'media_karya' => $validated['media_karya'],
            'dimensi' => $validated['dimensi'],
            'lokasi_asal' => $validated['lokasi_asal'],
            'thumbnail' => $thumbnailPath,
            'status_karya' => 'draft',
        ]);
        
        // Store additional media
        if ($request->hasFile('file_media')) {
            foreach ($request->file('file_media') as $index => $file) {
                $path = $file->store('karya/media', 'public');
                
                MediaKarya::create([
                    'karya_seni_id' => $karya->id,
                    'jenis_media' => 'gambar',
                    'nama_file' => $file->getClientOriginalName(),
                    'path_file' => $path,
                    'ukuran_file' => $file->getSize(),
                    'urutan' => $index,
                ]);
            }
        }
        
        return redirect()->route('seniman.karya.index')->with('success', 'Karya berhasil ditambahkan sebagai draft.');
    }
    
    public function edit(KaryaSeni $karyaSeni)
    {
        $this->authorize('update', $karyaSeni);
        
        $kategoriList = Kategori::aktif()->orderBy('urutan')->get();
        $karyaSeni->load('mediaKarya');
        
        return view('seniman.karya.edit', compact('karyaSeni', 'kategoriList'));
    }
    
    public function update(Request $request, KaryaSeni $karyaSeni)
    {
        $this->authorize('update', $karyaSeni);
        
        $validated = $request->validate([
            'judul_karya' => 'required|string|max:200',
            'kategori_id' => 'required|exists:kategori,id',
            'deskripsi_singkat' => 'required|string',
            'deskripsi_lengkap' => 'nullable|string',
            'tahun_karya' => 'nullable|string|max:20',
            'media_karya' => 'nullable|string|max:150',
            'dimensi' => 'nullable|string|max:100',
            'lokasi_asal' => 'nullable|string|max:150',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'file_media.*' => 'nullable|file|max:10240',
        ]);
        
        $updateData = [
            'judul_karya' => $validated['judul_karya'],
            'kategori_id' => $validated['kategori_id'],
            'deskripsi_singkat' => $validated['deskripsi_singkat'],
            'deskripsi_lengkap' => $validated['deskripsi_lengkap'],
            'tahun_karya' => $validated['tahun_karya'],
            'media_karya' => $validated['media_karya'],
            'dimensi' => $validated['dimensi'],
            'lokasi_asal' => $validated['lokasi_asal'],
        ];
        
        if ($request->hasFile('thumbnail')) {
            $updateData['thumbnail'] = $request->file('thumbnail')->store('karya/thumbnails', 'public');
        }
        
        $karyaSeni->update($updateData);
        
        // Store additional media
        if ($request->hasFile('file_media')) {
            foreach ($request->file('file_media') as $index => $file) {
                $path = $file->store('karya/media', 'public');
                
                MediaKarya::create([
                    'karya_seni_id' => $karyaSeni->id,
                    'jenis_media' => 'gambar',
                    'nama_file' => $file->getClientOriginalName(),
                    'path_file' => $path,
                    'ukuran_file' => $file->getSize(),
                    'urutan' => $karyaSeni->mediaKarya()->count() + $index,
                ]);
            }
        }
        
        return redirect()->route('seniman.karya.index')->with('success', 'Karya berhasil diperbarui.');
    }
    
    public function destroy(KaryaSeni $karyaSeni)
    {
        $this->authorize('delete', $karyaSeni);
        
        $karyaSeni->delete();
        
        return redirect()->route('seniman.karya.index')->with('success', 'Karya berhasil dihapus.');
    }
    
    public function ajukan(KaryaSeni $karyaSeni)
    {
        $this->authorize('update', $karyaSeni);
        
        if (!$karyaSeni->canBeSubmitted()) {
            return back()->with('error', 'Karya tidak dapat diajukan untuk review.');
        }
        
        $karyaSeni->update([
            'status_karya' => 'diajukan',
            'diajukan_pada' => now(),
        ]);
        
        return back()->with('success', 'Karya berhasil diajukan untuk review. Admin akan meninjau karya Anda.');
    }
}
