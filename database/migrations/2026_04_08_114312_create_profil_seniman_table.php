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
        Schema::create('profil_seniman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_panggung', 150)->nullable();
            $table->string('foto_profil', 255)->nullable();
            $table->string('foto_sampul', 255)->nullable();
            $table->longText('biografi')->nullable();
            $table->string('bidang_seni_utama', 100)->index();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan', 'lainnya'])->nullable();
            $table->text('alamat')->nullable();
            $table->string('kabupaten_kota', 100)->nullable();
            $table->string('provinsi', 100)->nullable();
            $table->string('instagram', 150)->nullable();
            $table->string('facebook', 150)->nullable();
            $table->string('youtube', 150)->nullable();
            $table->string('situs_web', 150)->nullable();
            $table->longText('prestasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_seniman');
    }
};
