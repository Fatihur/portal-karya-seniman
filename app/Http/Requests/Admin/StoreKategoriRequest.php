<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreKategoriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'nama_kategori' => 'required|string|max:100|unique:kategori',
            'slug' => 'nullable|string|max:120|unique:kategori',
            'deskripsi' => 'nullable|string',
            'status_aktif' => 'boolean',
        ];
    }
}
