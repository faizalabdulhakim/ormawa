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
        Schema::create('komentars', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe', ['proposal', 'lpj', 'lpj_akhir']);
            $table->foreignId('dokumen_id');
            $table->boolean('is_open')->default(false);
            $table->string('bagian')->nullable();
            $table->foreignId('user_id')->onDelete('cascade');
            $table->foreignId('ormawa_id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komentars');
    }
};
