<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MediaKarya extends Model
{
    protected $table = 'media_karya';

    protected $fillable = [
        'karya_seni_id',
        'jenis_media',
        'nama_file',
        'path_file',
        'ukuran_file',
        'urutan',
        'is_thumbnail',
    ];

    protected $casts = [
        'is_thumbnail' => 'boolean',
        'urutan' => 'integer',
    ];

    public function karyaSeni(): BelongsTo
    {
        return $this->belongsTo(KaryaSeni::class);
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path_file);
    }
}
