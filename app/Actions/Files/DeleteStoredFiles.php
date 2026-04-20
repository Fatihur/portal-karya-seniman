<?php

namespace App\Actions\Files;

use Illuminate\Support\Facades\Storage;

class DeleteStoredFiles
{
    public function handle(array|string|null $paths, string $disk = 'public'): void
    {
        $paths = is_array($paths) ? $paths : [$paths];
        $paths = array_values(array_filter($paths));

        if ($paths !== []) {
            Storage::disk($disk)->delete($paths);
        }
    }
}
