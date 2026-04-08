<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'email',
        'nomor_hp',
        'password',
        'peran',
        'status_akun',
        'terakhir_login_pada',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'terakhir_login_pada' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke profil seniman (one-to-one)
     */
    public function profilSeniman()
    {
        return $this->hasOne(ProfilSeniman::class);
    }

    /**
     * Relasi ke karya seni (one-to-many)
     */
    public function karyaSeni()
    {
        return $this->hasMany(KaryaSeni::class);
    }

    /**
     * Relasi ke review karya (one-to-many)
     */
    public function reviewKarya()
    {
        return $this->hasMany(ReviewKarya::class, 'admin_id');
    }

    /**
     * Relasi ke log aktivitas (one-to-many)
     */
    public function logAktivitas()
    {
        return $this->hasMany(LogAktivitas::class);
    }

    /**
     * Cek apakah user adalah admin
     */
    public function isAdmin(): bool
    {
        return $this->peran === 'admin';
    }

    /**
     * Cek apakah user adalah seniman
     */
    public function isSeniman(): bool
    {
        return $this->peran === 'seniman';
    }

    /**
     * Cek apakah akun aktif
     */
    public function isAktif(): bool
    {
        return $this->status_akun === 'aktif';
    }
}
