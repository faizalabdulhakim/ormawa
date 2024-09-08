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
        Schema::table('users', function($table) {
            $table->foreignId('ormawa_id')
                    ->nullable()
                    ->default(null);
            // $table->unique(['nama', 'nim', 'ormawa_id']);
        });
        
        Schema::table('ormawas', function($table) {
            $table->foreignId('ketua_id')
                    ->nullable();
            $table->foreignId('sekretaris_umum_id')
                    ->nullable();
            $table->foreignId('pembina_id')
                    ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
