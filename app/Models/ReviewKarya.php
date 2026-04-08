<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewKarya extends Model
{
    protected $table = 'review_karya';

    protected $fillable = [
        'karya_seni_id',
        'admin_id',
        'status_sebelum',
        'status_sesudah',
        'catatan_review',
        'ditinjau_pada',
    ];

    protected $casts = [
        'ditinjau_pada' => 'datetime',
    ];

    public function karyaSeni(): BelongsTo
    {
        return $this->belongsTo(KaryaSeni::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function getNamaAdminAttribute(): string
    {
        return $this->admin?->nama ?? 'Admin';
    }
}
