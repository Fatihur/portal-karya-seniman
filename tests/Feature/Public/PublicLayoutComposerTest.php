<?php

namespace Tests\Feature\Public;

use App\Models\Kategori;
use App\View\Composers\PublicLayoutComposer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicLayoutComposerTest extends TestCase
{
    use RefreshDatabase;

    public function test_composer_shares_sorted_active_categories(): void
    {
        Kategori::factory()->create([
            'nama_kategori' => 'Patung',
            'slug' => 'patung',
            'urutan' => 2,
            'status_aktif' => true,
        ]);

        Kategori::factory()->create([
            'nama_kategori' => 'Lukis',
            'slug' => 'lukis',
            'urutan' => 1,
            'status_aktif' => true,
        ]);

        Kategori::factory()->nonaktif()->create([
            'nama_kategori' => 'Arsip',
            'slug' => 'arsip',
            'urutan' => 0,
        ]);

        $view = view('welcome');

        (new PublicLayoutComposer())->compose($view);

        $items = $view->getData()['layoutKategoriList'];

        $this->assertSame(['Lukis', 'Patung'], $items->pluck('nama_kategori')->all());
    }
}
