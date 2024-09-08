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
        Schema::create('prokers', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->date('tanggal_pelaksanaan');
            $table->date('deadline_proposal');
            $table->date('deadline_lpj');
            $table->foreignId('ormawa_id')
                    ->onDelete('cascade')
                    ->nullable();
            $table->foreignId('user_id')
                    ->onDelete('cascade')
                    ->nullable();
            $table->timestamps();

            $table->unique(['tanggal_pelaksanaan', 'ormawa_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prokers');
    }
};
