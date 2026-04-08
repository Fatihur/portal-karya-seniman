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
        Schema::create('review_karya', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karya_seni_id')->constrained('karya_seni')->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->string('status_sebelum', 50);
            $table->string('status_sesudah', 50);
            $table->text('catatan_review')->nullable();
            $table->timestamp('ditinjau_pada');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_karya');
    }
};
