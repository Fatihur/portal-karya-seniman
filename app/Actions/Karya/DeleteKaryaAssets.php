<?php

namespace App\Actions\Karya;

use App\Actions\Files\DeleteStoredFiles;
use App\Models\KaryaSeni;

class DeleteKaryaAssets
{
    public function __construct(private DeleteStoredFiles $deleteStoredFiles)
    {
    }

    public function handle(KaryaSeni $karya): void
    {
        $karya->loadMissing('mediaKarya');

        $this->deleteStoredFiles->handle([
            $karya->thumbnail,
            ...$karya->mediaKarya->pluck('path_file')->all(),
        ]);

        $karya->mediaKarya()->delete();
    }
}
