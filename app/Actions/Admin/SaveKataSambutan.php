<?php

namespace App\Actions\Admin;

use App\Actions\Files\ReplaceStoredFile;
use App\Models\KataSambutan;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class SaveKataSambutan
{
    public function __construct(private ReplaceStoredFile $replaceStoredFile)
    {
    }

    public function handle(array $data, ?KataSambutan $kataSambutan = null): KataSambutan
    {
        $kataSambutan ??= new KataSambutan();

        return DB::transaction(function () use ($data, $kataSambutan) {
            if (($data['foto'] ?? null) instanceof UploadedFile) {
                $data['foto'] = $this->replaceStoredFile->handle($kataSambutan->foto, $data['foto'], 'sambutan');
            } else {
                unset($data['foto']);
            }

            $data['status_aktif'] = (bool) ($data['status_aktif'] ?? false);

            if ($data['status_aktif']) {
                KataSambutan::query()
                    ->when($kataSambutan->exists, fn ($query) => $query->whereKeyNot($kataSambutan->id))
                    ->where('status_aktif', true)
                    ->update(['status_aktif' => false]);
            }

            $kataSambutan->fill($data)->save();

            return $kataSambutan;
        });
    }
}
