<?php

namespace App\Actions\Admin;

use App\Actions\Files\ReplaceStoredFile;
use App\Models\Slider;
use Illuminate\Http\UploadedFile;

class SaveSlider
{
    public function __construct(private ReplaceStoredFile $replaceStoredFile)
    {
    }

    public function handle(array $data, ?Slider $slider = null): Slider
    {
        $slider ??= new Slider();

        if (($data['gambar'] ?? null) instanceof UploadedFile) {
            $data['gambar'] = $this->replaceStoredFile->handle($slider->gambar, $data['gambar'], 'sliders');
        } else {
            unset($data['gambar']);
        }

        $data['status_aktif'] = (bool) ($data['status_aktif'] ?? false);

        $slider->fill($data)->save();

        return $slider;
    }
}
