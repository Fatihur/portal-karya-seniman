<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kata_sambutan', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 200);
            $table->string('nama_tokoh', 150);
            $table->string('jabatan', 150)->nullable();
            $table->string('foto', 255)->nullable();
            $table->longText('isi_sambutan');
            $table->boolean('status_aktif')->default(true)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kata_sambutan');
    }
};
