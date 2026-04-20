<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKataSambutanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:200',
            'nama_tokoh' => 'required|string|max:150',
            'jabatan' => 'nullable|string|max:150',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'isi_sambutan' => 'required|string',
            'status_aktif' => 'boolean',
        ];
    }
}
