<?php

namespace App\Actions\Karya;

use App\Enums\KaryaStatus;
use App\Models\KaryaSeni;
use App\Models\User;

class CreateKaryaDraft
{
    public function __construct(private StoreUploadedKaryaMedia $storeUploadedKaryaMedia)
    {
    }

    public function handle(User $user, array $data): KaryaSeni
    {
        $thumbnailFile = $data['thumbnail'];
        $mediaFiles = $data['file_media'] ?? [];

        unset($data['thumbnail'], $data['file_media']);

        $karya = KaryaSeni::create([
            ...$data,
            'user_id' => $user->id,
            'thumbnail' => $thumbnailFile->store('karya/thumbnails', 'public'),
            'status_karya' => KaryaStatus::Draft->value,
        ]);

        $this->storeUploadedKaryaMedia->handle($karya, $mediaFiles);

        return $karya->load('mediaKarya');
    }
}
