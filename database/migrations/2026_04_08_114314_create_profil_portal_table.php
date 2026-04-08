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
        Schema::create('profil_portal', function (Blueprint $table) {
            $table->id();
            $table->string('nama_portal', 200);
            $table->string('logo', 255)->nullable();
            $table->string('favicon', 255)->nullable();
            $table->longText('sejarah')->nullable();
            $table->text('visi')->nullable();
            $table->longText('misi')->nullable();
            $table->text('alamat')->nullable();
            $table->string('email_kontak', 150)->nullable();
            $table->string('telepon', 30)->nullable();
            $table->longText('peta_embed')->nullable();
            $table->string('instagram', 150)->nullable();
            $table->string('facebook', 150)->nullable();
            $table->string('youtube', 150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_portal');
    }
};
