<?php

namespace App\View\Composers;

use App\Models\Kategori;
use Illuminate\View\View;

class PublicLayoutComposer
{
    public function compose(View $view): void
    {
        $view->with('layoutKategoriList', Kategori::aktif()->orderBy('urutan')->get());
    }
}
