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
        Schema::create('media_karya', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karya_seni_id')->constrained('karya_seni')->onDelete('cascade');
            $table->enum('jenis_media', ['gambar', 'video', 'audio', 'dokumen'])->index();
            $table->string('nama_file', 255);
            $table->string('path_file', 255);
            $table->unsignedBigInteger('ukuran_file')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('is_thumbnail')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_karya');
    }
};
