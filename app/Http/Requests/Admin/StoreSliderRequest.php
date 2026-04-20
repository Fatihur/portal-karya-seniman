<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreSliderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:200',
            'subjudul' => 'nullable|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'tautan' => 'nullable|string|max:255',
            'teks_tombol' => 'nullable|string|max:100',
            'urutan' => 'nullable|integer',
            'status_aktif' => 'boolean',
        ];
    }
}
