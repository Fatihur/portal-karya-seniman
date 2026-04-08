<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogAktivitas extends Model
{
    protected $table = 'log_aktivitas';

    protected $fillable = [
        'user_id',
        'modul',
        'aksi',
        'deskripsi',
        'alamat_ip',
        'agen_pengguna',
        'data_referensi_tipe',
        'data_referensi_id',
        'dibuat_pada',
    ];

    protected $casts = [
        'dibuat_pada' => 'datetime',
    ];

    public $timestamps = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function catat($data): self
    {
        return self::create([
            'user_id' => $data['user_id'] ?? auth()->id(),
            'modul' => $data['modul'],
            'aksi' => $data['aksi'],
            'deskripsi' => $data['deskripsi'] ?? null,
            'alamat_ip' => request()->ip(),
            'agen_pengguna' => request()->userAgent(),
            'data_referensi_tipe' => $data['data_referensi_tipe'] ?? null,
            'data_referensi_id' => $data['data_referensi_id'] ?? null,
            'dibuat_pada' => now(),
        ]);
    }
}
