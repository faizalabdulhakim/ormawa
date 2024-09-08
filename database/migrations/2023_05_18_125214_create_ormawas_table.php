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
        Schema::create('ormawas', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->default('../images/polsub.png');
            $table->string('nama');
            $table->enum('jenis', ['UKM', 'HMJ', 'BEM', 'MPM'])->default('UKM');
            $table->string('jurusan')->nullable();
            $table->string('angkatan')->default(date('Y'));
            $table->text('deskripsi')->nullable();
            $table->string('cover')->nullable();
            $table->text('kata_pengantar')->nullable();
            $table->text('bab1')->nullable();
            $table->text('bab2')->nullable();
            $table->text('laporan_admin')->nullable();
            $table->text('laporan_keuangan')->nullable();
            $table->text('bab3')->nullable();
            $table->string('ketua_jurusan')->nullable();
            $table->string('nip_ketua_jurusan')->nullable();
            $table->string('bukti_transaksi')->nullable();
            $table->string('dokumentasi')->nullable();
            $table->timestamps();

            $table->unique(['nama', 'angkatan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ormawas');
    }
};
