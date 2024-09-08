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
        Schema::create('lpjs', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('proposal_id');
            $table->string('cover')->nullable();

            $table->text('kata_pengantar')->nullable();
            $table->text('komentar_kata_pengantar')->nullable();
            $table->text('latar_belakang')->nullable();
            $table->text('komentar_latar_belakang')->nullable();
            $table->text('nama')->nullable();
            $table->text('komentar_nama')->nullable();
            $table->text('tema')->nullable();
            $table->text('komentar_tema')->nullable();
            $table->text('tujuan')->nullable();
            $table->text('komentar_tujuan')->nullable();
            $table->text('sasaran')->nullable();
            $table->text('komentar_sasaran')->nullable();
            $table->text('konsep')->nullable();
            $table->text('komentar_konsep')->nullable();
            $table->text('waktu')->nullable();
            $table->text('komentar_waktu')->nullable();
            $table->text('kendala')->nullable();
            $table->text('komentar_kendala')->nullable();
            $table->text('susunan_kegiatan')->nullable();
            $table->text('komentar_susunan_kegiatan')->nullable();
            $table->text('susunan_kepanitiaan')->nullable();
            $table->text('komentar_susunan_kepanitiaan')->nullable();
            $table->text('rab')->nullable();
            $table->text('komentar_rab')->nullable();
            $table->text('penutup')->nullable();
            $table->text('komentar_penutup')->nullable();
            $table->text('bukti_transaksi')->nullable();
            $table->text('komentar_bukti_transaksi')->nullable();
            $table->text('dokumentasi')->nullable();
            $table->text('komentar_dokumentasi')->nullable();

            $table->boolean('isViewed')->default(false);

            $table->foreignId('proker_id')
                    ->onDelete('cascade')
                    ->nullable();
            $table->foreignId('user_id')
                    ->onDelete('cascade')
                    ->nullable();

            $table->enum('status', ['tanpa_isi','draft', 'diajukan', 'disetujui','ditolak'])
                    ->default('tanpa_isi')
                    ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lpjs');
    }
};
