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
        Schema::create('ormawa_user', function (Blueprint $table) {
            $table->integer('ormawa_id');
            $table->integer('user_id');
            $table->enum('role', ['admin', 'sekretaris_umum', 'sekretaris_proker','anggota', 'ketua', 'pembina', 'wadir'])
                    ->default('anggota')
                    ->nullable();
            $table->enum('status', ['aktif', 'pending']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ormawa_user');
    }
};
