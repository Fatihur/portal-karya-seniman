<?php

namespace App\Http\Requests\Seniman;

use App\Models\KaryaSeni;
use Illuminate\Foundation\Http\FormRequest;

class StoreKaryaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', KaryaSeni::class) ?? false;
    }

    public function rules(): array
    {
        return [
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
        ];
    }
}
