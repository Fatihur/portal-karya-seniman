<?php

namespace App\Actions\Karya;

use App\Actions\Files\ReplaceStoredFile;
use App\Models\KaryaSeni;

class UpdateKaryaDraft
{
    public function __construct(
        private ReplaceStoredFile $replaceStoredFile,
        private StoreUploadedKaryaMedia $storeUploadedKaryaMedia,
    ) {
    }

    public function handle(KaryaSeni $karya, array $data): KaryaSeni
    {
        $thumbnailFile = $data['thumbnail'] ?? null;
        $mediaFiles = $data['file_media'] ?? [];

        unset($data['thumbnail'], $data['file_media']);

        if ($thumbnailFile) {
            $data['thumbnail'] = $this->replaceStoredFile->handle(
                $karya->thumbnail,
                $thumbnailFile,
                'karya/thumbnails',
            );
        }

        $karya->update($data);
        $this->storeUploadedKaryaMedia->handle($karya, $mediaFiles);

        return $karya->refresh();
    }
}
