<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'judul',
        'subjudul',
        'gambar',
        'tautan',
        'teks_tombol',
        'urutan',
        'status_aktif',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
        'urutan' => 'integer',
    ];

    public function scopeAktif($query)
    {
        return $query->where('status_aktif', true)->orderBy('urutan');
    }

    public function getGambarUrlAttribute(): string
    {
        return asset('storage/' . $this->gambar);
    }
}
