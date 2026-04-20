<?php

namespace App\Actions\Karya;

use App\Models\KaryaSeni;
use App\Models\MediaKarya;
use Illuminate\Http\UploadedFile;

class StoreUploadedKaryaMedia
{
    public function handle(KaryaSeni $karya, array $files = []): void
    {
        $existingCount = $karya->mediaKarya()->count();

        foreach ($files as $index => $file) {
            if (! $file instanceof UploadedFile) {
                continue;
            }

            $path = $file->store('karya/media', 'public');

            MediaKarya::create([
                'karya_seni_id' => $karya->id,
                'jenis_media' => 'gambar',
                'nama_file' => $file->getClientOriginalName(),
                'path_file' => $path,
                'ukuran_file' => $file->getSize(),
                'urutan' => $existingCount + $index,
            ]);
        }
    }
}
