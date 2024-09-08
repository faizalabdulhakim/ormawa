<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\GaleriOrmawa;
use App\Models\Lpj;
use App\Models\Ormawa;
use App\Models\Proker;
use App\Models\Proposal;
use App\Models\ProposalDetail;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
        public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // 1
        User::create([
            'nama' => 'admin',
            'username' => 'admin',
            'status' => 'aktif',
            'password' => bcrypt('admin123'),
            'ormawa_id' => 1
        ]);
        
        // 2
        User::create([
            'nama' => 'Wadir Polsub',
            'username' => 'wadir-polsub',
            'status' => 'aktif',
            'password' => bcrypt('admin123'),
        ]);
        
        // 3
        // Ormawa::create([
        //     'nama' => 'BEM',
        //     'logo' => 'bem.png',
        //     'deskripsi' => 'BEM',
        //     'angkatan' => '2020',
        //     'jenis' => 'BEM',
        // ]);

        // find user with id 1 and attach it to ormawa with id 1
        // User::find(1)->ormawas()->attach(1);

        
    }
}
