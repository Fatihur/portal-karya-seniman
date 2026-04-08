<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class KaryaSeni extends Model
{
    use SoftDeletes;

    protected $table = 'karya_seni';

    protected $fillable = [
        'user_id',
        'kategori_id',
        'judul_karya',
        'slug',
        'deskripsi_singkat',
        'deskripsi_lengkap',
        'tahun_karya',
        'media_karya',
        'dimensi',
        'lokasi_asal',
        'thumbnail',
        'status_karya',
        'catatan_admin_terbaru',
        'diajukan_pada',
        'disetujui_pada',
        'dipublikasikan_pada',
        'jumlah_dilihat',
        'status_aktif',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
        'jumlah_dilihat' => 'integer',
        'diajukan_pada' => 'datetime',
        'disetujui_pada' => 'datetime',
        'dipublikasikan_pada' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    public function mediaKarya(): HasMany
    {
        return $this->hasMany(MediaKarya::class);
    }

    public function reviewKarya(): HasMany
    {
        return $this->hasMany(ReviewKarya::class);
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : null;
    }

    public function getNamaSenimanAttribute(): string
    {
        return $this->user?->profilSeniman?->nama_tampilan ?? $this->user?->nama ?? 'Unknown';
    }

    public function scopePublik($query)
    {
        return $query->where('status_karya', 'dipublikasikan')->where('status_aktif', true);
    }

    public function scopeMilikSeniman($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status_karya', $status);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($karya) {
            if (empty($karya->slug)) {
                $karya->slug = Str::slug($karya->judul_karya) . '-' . uniqid();
            }
        });
    }

    public function incrementViewCount(): void
    {
        $this->increment('jumlah_dilihat');
    }

    public function canBeEditedBy(User $user): bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        return $this->user_id === $user->id && in_array($this->status_karya, ['draft', 'perlu_revisi']);
    }

    public function canBeSubmitted(): bool
    {
        return in_array($this->status_karya, ['draft', 'perlu_revisi']);
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status_karya) {
            'draft' => 'secondary',
            'diajukan' => 'info',
            'perlu_revisi' => 'warning',
            'disetujui' => 'success',
            'ditolak' => 'danger',
            'dipublikasikan' => 'primary',
            'diarsipkan' => 'dark',
            default => 'secondary',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status_karya) {
            'draft' => 'Draft',
            'diajukan' => 'Diajukan',
            'perlu_revisi' => 'Perlu Revisi',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            'dipublikasikan' => 'Dipublikasikan',
            'diarsipkan' => 'Diarsipkan',
            default => $this->status_karya,
        };
    }
}
