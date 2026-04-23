<?php

namespace App\Actions\Admin;

use App\Models\Kategori;
use Illuminate\Support\Str;

class SaveKategori
{
    public function handle(array $data, ?Kategori $kategori = null): Kategori
    {
        $kategori ??= new Kategori();

        if (blank($data['slug'] ?? null)) {
            $data['slug'] = Str::slug($data['nama_kategori']);
        }

        $data['status_aktif'] = (bool) ($data['status_aktif'] ?? false);

        $kategori->fill($data)->save();

        return $kategori;
    }
}
