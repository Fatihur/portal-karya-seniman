<?php

namespace Tests\Feature\Karya;

use App\Models\KaryaSeni;
use App\Models\Kategori;
use App\Models\MediaKarya;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class KaryaFileLifecycleTest extends TestCase
{
    use RefreshDatabase;

    public function test_updating_a_thumbnail_replaces_the_old_file(): void
    {
        Storage::fake('public');

        $owner = User::factory()->seniman()->create();
        $kategori = Kategori::factory()->create();
        $karya = KaryaSeni::factory()->for($owner)->for($kategori)->draft()->create([
            'thumbnail' => 'karya/thumbnails/old.webp',
        ]);

        Storage::disk('public')->put('karya/thumbnails/old.webp', 'old-image');

        $response = $this->actingAs($owner)->put(route('seniman.karya.update', $karya), [
            'judul_karya' => 'Judul Baru',
            'kategori_id' => $kategori->id,
            'deskripsi_singkat' => 'Ringkas',
            'deskripsi_lengkap' => 'Lengkap',
            'tahun_karya' => '2024',
            'media_karya' => 'Akrilik',
            'dimensi' => '50x50 cm',
            'lokasi_asal' => 'Sumbawa',
            'thumbnail' => UploadedFile::fake()->image('new.webp'),
        ]);

        $response->assertRedirect(route('seniman.karya.index'));

        $karya->refresh();

        Storage::disk('public')->assertMissing('karya/thumbnails/old.webp');
        Storage::disk('public')->assertExists($karya->thumbnail);
    }

    public function test_deleting_a_karya_removes_thumbnail_and_media_files(): void
    {
        Storage::fake('public');

        $owner = User::factory()->seniman()->create();
        $kategori = Kategori::factory()->create();
        $karya = KaryaSeni::factory()->for($owner)->for($kategori)->draft()->create([
            'thumbnail' => 'karya/thumbnails/delete-me.webp',
        ]);

        Storage::disk('public')->put('karya/thumbnails/delete-me.webp', 'thumb');
        Storage::disk('public')->put('karya/media/delete-me.jpg', 'media');

        $media = MediaKarya::create([
            'karya_seni_id' => $karya->id,
            'jenis_media' => 'gambar',
            'nama_file' => 'delete-me.jpg',
            'path_file' => 'karya/media/delete-me.jpg',
            'ukuran_file' => 5,
            'urutan' => 0,
        ]);

        $response = $this->actingAs($owner)
            ->delete(route('seniman.karya.destroy', $karya));

        $response->assertRedirect(route('seniman.karya.index'));

        Storage::disk('public')->assertMissing('karya/thumbnails/delete-me.webp');
        Storage::disk('public')->assertMissing('karya/media/delete-me.jpg');
        $this->assertSoftDeleted('karya_seni', ['id' => $karya->id]);
        $this->assertDatabaseMissing('media_karya', ['id' => $media->id]);
    }
}
