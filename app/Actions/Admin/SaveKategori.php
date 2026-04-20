<?php

namespace App\Actions\Admin;

use App\Actions\Files\ReplaceStoredFile;
use App\Models\Kategori;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class SaveKategori
{
    public function __construct(private ReplaceStoredFile $replaceStoredFile)
    {
    }

    public function handle(array $data, ?Kategori $kategori = null): Kategori
    {
        $kategori ??= new Kategori();

        if (blank($data['slug'] ?? null)) {
            $data['slug'] = Str::slug($data['nama_kategori']);
        }

        if (($data['gambar'] ?? null) instanceof UploadedFile) {
            $data['gambar'] = $this->replaceStoredFile->handle($kategori->gambar, $data['gambar'], 'kategori');
        } else {
            unset($data['gambar']);
        }

        $data['status_aktif'] = (bool) ($data['status_aktif'] ?? false);

        $kategori->fill($data)->save();

        return $kategori;
    }
}
