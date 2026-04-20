<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\SaveKategori;
use App\Actions\Files\DeleteStoredFiles;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreKategoriRequest;
use App\Http\Requests\Admin\UpdateKategoriRequest;
use App\Models\Kategori;

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

    public function store(StoreKategoriRequest $request, SaveKategori $saveKategori)
    {
        $saveKategori->handle($request->validated());

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

    public function update(UpdateKategoriRequest $request, Kategori $kategori, SaveKategori $saveKategori)
    {
        $saveKategori->handle($request->validated(), $kategori);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori, DeleteStoredFiles $deleteStoredFiles)
    {
        if ($kategori->karyaSeni()->count() > 0) {
            return redirect()->route('admin.kategori.index')->with('error', 'Kategori tidak dapat dihapus karena masih memiliki karya.');
        }

        $deleteStoredFiles->handle($kategori->gambar);
        $kategori->delete();

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
