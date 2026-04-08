<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    protected $table = 'kategori';

    protected $fillable = [
        'nama_kategori',
        'slug',
        'deskripsi',
        'ikon',
        'gambar',
        'urutan',
        'status_aktif',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * Relasi ke karya seni (has-many)
     */
    public function karyaSeni(): HasMany
    {
        return $this->hasMany(KaryaSeni::class);
    }

    /**
     * Get karya yang dipublikasikan
     */
    public function karyaSeniPublik(): HasMany
    {
        return $this->hasMany(KaryaSeni::class)->where('status_karya', 'dipublikasikan');
    }

    /**
     * Scope untuk kategori aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status_aktif', true);
    }

    /**
     * Boot method untuk auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($kategori) {
            if (empty($kategori->slug)) {
                $kategori->slug = \Illuminate\Support\Str::slug($kategori->nama_kategori);
            }
        });

        static::updating(function ($kategori) {
            if ($kategori->isDirty('nama_kategori') && empty($kategori->slug)) {
                $kategori->slug = \Illuminate\Support\Str::slug($kategori->nama_kategori);
            }
        });
    }
}
