<?php

namespace Tests\Feature\Admin;

use App\Models\KataSambutan;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SupportingCrudRefactorTest extends TestCase
{
    use RefreshDatabase;

    public function test_slider_update_replaces_the_previous_image(): void
    {
        Storage::fake('public');

        $admin = User::factory()->admin()->create();
        Storage::disk('public')->put('sliders/old.webp', 'old-slider');

        $slider = Slider::create([
            'judul' => 'Slider Lama',
            'subjudul' => 'Subjudul',
            'gambar' => 'sliders/old.webp',
            'tautan' => '/karya',
            'teks_tombol' => 'Lihat',
            'urutan' => 1,
            'status_aktif' => true,
        ]);

        $response = $this->actingAs($admin)->put(route('admin.slider.update', $slider), [
            'judul' => 'Slider Baru',
            'subjudul' => 'Subjudul Baru',
            'gambar' => UploadedFile::fake()->image('new.webp'),
            'tautan' => '/profil',
            'teks_tombol' => 'Buka',
            'urutan' => 2,
            'status_aktif' => '1',
        ]);

        $response->assertRedirect(route('admin.slider.index'));

        $slider->refresh();

        Storage::disk('public')->assertMissing('sliders/old.webp');
        Storage::disk('public')->assertExists($slider->gambar);
    }

    public function test_storing_an_active_kata_sambutan_deactivates_the_previous_active_record(): void
    {
        $admin = User::factory()->admin()->create();

        $existing = KataSambutan::create([
            'judul' => 'Sambutan Lama',
            'nama_tokoh' => 'Tokoh Lama',
            'jabatan' => 'Ketua',
            'foto' => null,
            'isi_sambutan' => 'Isi lama',
            'status_aktif' => true,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.kata-sambutan.store'), [
            'judul' => 'Sambutan Baru',
            'nama_tokoh' => 'Tokoh Baru',
            'jabatan' => 'Bupati',
            'isi_sambutan' => 'Isi baru',
            'status_aktif' => '1',
        ]);

        $response->assertRedirect(route('admin.kata-sambutan.index'));

        $this->assertFalse($existing->fresh()->status_aktif);
        $this->assertTrue(KataSambutan::latest('id')->first()->status_aktif);
    }

    public function test_storing_a_category_without_a_slug_generates_one(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.kategori.store'), [
            'nama_kategori' => 'Seni Anyar',
            'deskripsi' => 'Kategori baru',
            'ikon' => 'bi bi-palette',
            'urutan' => 3,
            'status_aktif' => '1',
        ]);

        $response->assertRedirect(route('admin.kategori.index'));

        $this->assertDatabaseHas('kategori', [
            'nama_kategori' => 'Seni Anyar',
            'slug' => 'seni-anyar',
        ]);
    }
}
