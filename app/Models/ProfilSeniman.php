<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfilSeniman extends Model
{
    protected $table = 'profil_seniman';

    protected $fillable = [
        'user_id',
        'nama_panggung',
        'foto_profil',
        'foto_sampul',
        'biografi',
        'bidang_seni_utama',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'kabupaten_kota',
        'provinsi',
        'instagram',
        'facebook',
        'youtube',
        'situs_web',
        'prestasi',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Relasi ke user (belongs-to)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get nama lengkap dari user
     */
    public function getNamaLengkapAttribute(): string
    {
        return $this->user?->nama ?? '-';
    }

    /**
     * Get nama tampilan
     */
    public function getNamaTampilanAttribute(): string
    {
        return $this->nama_panggung ?? $this->getNamaLengkapAttribute();
    }

    /**
     * Get URL foto profil
     */
    public function getFotoProfilUrlAttribute(): string
    {
        return $this->foto_profil ? asset('storage/' . $this->foto_profil) : asset('images/no-avatar.jpg');
    }

    /**
     * Get URL foto sampul
     */
    public function getFotoSampulUrlAttribute(): ?string
    {
        return $this->foto_sampul ? asset('storage/' . $this->foto_sampul) : null;
    }
}
