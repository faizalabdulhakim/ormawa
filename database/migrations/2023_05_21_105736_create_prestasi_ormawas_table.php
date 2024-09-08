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
        Schema::create('prestasi_ormawas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->foreignId('ormawa_id')->references('id')->on('ormawas')->onDelete('cascade')->onUpdate('cascade');
            $table->string('sertifikat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestasi_ormawas');
    }
};
