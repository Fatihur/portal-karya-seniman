<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilPortal extends Model
{
    protected $table = 'profil_portal';

    protected $fillable = [
        'nama_portal',
        'logo',
        'favicon',
        'sejarah',
        'visi',
        'misi',
        'alamat',
        'email_kontak',
        'telepon',
        'peta_embed',
        'instagram',
        'facebook',
        'youtube',
    ];

    public function getLogoUrlAttribute(): string
    {
        return $this->logo ? asset('storage/' . $this->logo) : asset('images/logo-default.png');
    }

    public function getFaviconUrlAttribute(): string
    {
        return $this->favicon ? asset('storage/' . $this->favicon) : asset('images/favicon-default.png');
    }
}
