<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KataSambutan extends Model
{
    protected $table = 'kata_sambutan';

    protected $fillable = [
        'judul',
        'nama_tokoh',
        'jabatan',
        'foto',
        'isi_sambutan',
        'status_aktif',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
    ];

    public function scopeAktif($query)
    {
        return $query->where('status_aktif', true);
    }

    public function getFotoUrlAttribute(): string
    {
        return $this->foto ? asset('storage/' . $this->foto) : asset('images/no-avatar.jpg');
    }
}
