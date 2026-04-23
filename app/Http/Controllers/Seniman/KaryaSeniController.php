<?php

namespace App\Http\Controllers\Seniman;

use App\Actions\Karya\CreateKaryaDraft;
use App\Actions\Karya\DeleteKaryaAssets;
use App\Actions\Karya\SubmitKaryaForReview;
use App\Actions\Karya\UpdateKaryaDraft;
use App\Http\Controllers\Controller;
use App\Http\Requests\Seniman\StoreKaryaRequest;
use App\Http\Requests\Seniman\UpdateKaryaRequest;
use App\Models\KaryaSeni;
use App\Models\Kategori;

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
        $kategoriList = Kategori::aktif()->orderBy('nama_kategori')->get();
        return view('seniman.karya.create', compact('kategoriList'));
    }
    
    public function store(StoreKaryaRequest $request, CreateKaryaDraft $action)
    {
        $action->handle($request->user(), $request->validated());

        return redirect()->route('seniman.karya.index')->with('success', 'Karya berhasil ditambahkan sebagai draft.');
    }
    
    public function edit(KaryaSeni $karyaSeni)
    {
        $this->authorize('update', $karyaSeni);
        
        $kategoriList = Kategori::aktif()->orderBy('nama_kategori')->get();
        $karyaSeni->load('mediaKarya');
        
        return view('seniman.karya.edit', compact('karyaSeni', 'kategoriList'));
    }
    
    public function update(UpdateKaryaRequest $request, KaryaSeni $karyaSeni, UpdateKaryaDraft $action)
    {
        $action->handle($karyaSeni, $request->validated());

        return redirect()->route('seniman.karya.index')->with('success', 'Karya berhasil diperbarui.');
    }
    
    public function destroy(KaryaSeni $karyaSeni, DeleteKaryaAssets $action)
    {
        $this->authorize('delete', $karyaSeni);

        $action->handle($karyaSeni);
        $karyaSeni->delete();

        return redirect()->route('seniman.karya.index')->with('success', 'Karya berhasil dihapus.');
    }
    
    public function ajukan(KaryaSeni $karyaSeni, SubmitKaryaForReview $action)
    {
        $this->authorize('update', $karyaSeni);

        $action->handle($karyaSeni);

        return back()->with('success', 'Karya berhasil diajukan untuk review. Admin akan meninjau karya Anda.');
    }
}
