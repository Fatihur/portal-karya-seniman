<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\SaveSlider;
use App\Actions\Files\DeleteStoredFiles;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSliderRequest;
use App\Http\Requests\Admin\UpdateSliderRequest;
use App\Models\Slider;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('urutan')->get();
        return view('admin.slider.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.slider.create');
    }

    public function store(StoreSliderRequest $request, SaveSlider $saveSlider)
    {
        $saveSlider->handle($request->validated());

        return redirect()->route('admin.slider.index')->with('success', 'Slider berhasil ditambahkan.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.slider.edit', compact('slider'));
    }

    public function update(UpdateSliderRequest $request, Slider $slider, SaveSlider $saveSlider)
    {
        $saveSlider->handle($request->validated(), $slider);

        return redirect()->route('admin.slider.index')->with('success', 'Slider berhasil diperbarui.');
    }

    public function destroy(Slider $slider, DeleteStoredFiles $deleteStoredFiles)
    {
        $deleteStoredFiles->handle($slider->gambar);
        $slider->delete();

        return redirect()->route('admin.slider.index')->with('success', 'Slider berhasil dihapus.');
    }
}
