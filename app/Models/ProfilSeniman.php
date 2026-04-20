<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class ProfilSeniman extends Model
{
    use HasFactory;

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

    public function karyaPublik(): HasManyThrough
    {
        return $this->hasManyThrough(KaryaSeni::class, User::class, 'id', 'user_id', 'user_id', 'id')
            ->where('karya_seni.status_karya', 'dipublikasikan')
            ->where('karya_seni.status_aktif', true);
    }

    public function scopePublicVisible($query)
    {
        return $query->whereHas('user', function ($q) {
            $q->where('status_akun', 'aktif')
                ->where('peran', 'seniman');
        });
    }

    public function scopeSearch($query, ?string $term)
    {
        if (! $term) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->whereHas('user', function ($userQuery) use ($term) {
                $userQuery->where('nama', 'like', '%' . $term . '%');
            })->orWhere('nama_panggung', 'like', '%' . $term . '%');
        });
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
