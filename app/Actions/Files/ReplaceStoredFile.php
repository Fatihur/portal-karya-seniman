<?php

namespace App\Actions\Files;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ReplaceStoredFile
{
    public function handle(?string $currentPath, UploadedFile $uploadedFile, string $directory, string $disk = 'public'): string
    {
        $newPath = $uploadedFile->store($directory, $disk);

        if ($currentPath && Storage::disk($disk)->exists($currentPath)) {
            Storage::disk($disk)->delete($currentPath);
        }

        return $newPath;
    }
}
