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
        Schema::create('karya_seni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('restrict');
            $table->string('judul_karya', 200)->index();
            $table->string('slug', 220)->unique();
            $table->text('deskripsi_singkat');
            $table->longText('deskripsi_lengkap')->nullable();
            $table->string('tahun_karya', 20)->nullable();
            $table->string('media_karya', 150)->nullable();
            $table->string('dimensi', 100)->nullable();
            $table->string('lokasi_asal', 150)->nullable();
            $table->string('thumbnail', 255);
            $table->enum('status_karya', ['draft', 'diajukan', 'perlu_revisi', 'disetujui', 'ditolak', 'dipublikasikan', 'diarsipkan'])->default('draft')->index();
            $table->text('catatan_admin_terbaru')->nullable();
            $table->timestamp('diajukan_pada')->nullable();
            $table->timestamp('disetujui_pada')->nullable();
            $table->timestamp('dipublikasikan_pada')->nullable();
            $table->unsignedBigInteger('jumlah_dilihat')->default(0);
            $table->boolean('status_aktif')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karya_seni');
    }
};
