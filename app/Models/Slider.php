<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'judul',
        'subjudul',
        'gambar',
        'status_aktif',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
    ];

    public function scopeAktif($query)
    {
        return $query->where('status_aktif', true)->latest();
    }

    public function getGambarUrlAttribute(): string
    {
        return asset('storage/' . $this->gambar);
    }
}
