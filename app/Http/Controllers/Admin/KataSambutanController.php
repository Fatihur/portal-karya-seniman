<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\SaveKataSambutan;
use App\Actions\Files\DeleteStoredFiles;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreKataSambutanRequest;
use App\Http\Requests\Admin\UpdateKataSambutanRequest;
use App\Models\KataSambutan;

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

    public function store(StoreKataSambutanRequest $request, SaveKataSambutan $saveKataSambutan)
    {
        $saveKataSambutan->handle($request->validated());

        return redirect()->route('admin.kata-sambutan.index')->with('success', 'Kata sambutan berhasil ditambahkan.');
    }

    public function edit(KataSambutan $kataSambutan)
    {
        return view('admin.kata-sambutan.edit', compact('kataSambutan'));
    }

    public function update(UpdateKataSambutanRequest $request, KataSambutan $kataSambutan, SaveKataSambutan $saveKataSambutan)
    {
        $saveKataSambutan->handle($request->validated(), $kataSambutan);

        return redirect()->route('admin.kata-sambutan.index')->with('success', 'Kata sambutan berhasil diperbarui.');
    }

    public function destroy(KataSambutan $kataSambutan, DeleteStoredFiles $deleteStoredFiles)
    {
        $deleteStoredFiles->handle($kataSambutan->foto);
        $kataSambutan->delete();

        return redirect()->route('admin.kata-sambutan.index')->with('success', 'Kata sambutan berhasil dihapus.');
    }
}
