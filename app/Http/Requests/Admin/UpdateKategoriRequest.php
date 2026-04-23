<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKategoriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $kategori = $this->route('kategori');

        return [
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori,' . $kategori->id,
            'slug' => 'nullable|string|max:120|unique:kategori,slug,' . $kategori->id,
            'deskripsi' => 'nullable|string',
            'status_aktif' => 'boolean',
        ];
    }
}
