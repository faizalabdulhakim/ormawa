<?php

namespace Database\Seeders;

use App\Models\Ormawa;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        // 1
        Ormawa::create([
            'nama' => 'MPM',
            'ketua_id' => 2,
            'sekretaris_umum_id' => 3,
            'pembina_id' => 5,
            'angkatan' => '2023',
            'jenis' => 'MPM',
        ]);

        // 2
        Ormawa::create([
            'nama' => 'BEM',
            'ketua_id' => 6,
            'sekretaris_umum_id' => 7,
            'pembina_id' => 9,
            'angkatan' => '2023',
            'jenis' => 'BEM',
        ]);

        // 3
        Ormawa::create([
            'nama' => 'Informatika',
            'ketua_id' => 11,
            'sekretaris_umum_id' => 12,
            'pembina_id' => 14,
            'angkatan' => '2023',
            'jenis' => 'HMJ',
            'jurusan' => 'Manajemen Informatika'
        ]);

        // 4
        Ormawa::create([
            'nama' => 'Badminton',
            'ketua_id' => 15,
            'sekretaris_umum_id' => 16,
            'pembina_id' => 18,
            'angkatan' => '2023',
            'jenis' => 'UKM',
        ]);

        // 2
        User::create([
            'nama' => 'Ketua MPM-KEMA-POLSUB',
            'username' => 'Ketua-MPM-KEMA-POLSUB',
            'nim' => '201524050',
            'password' => bcrypt('admin123'),
            'role' => 'ketua',
            'ormawa_id' => 1
        ]);

        // 3
        User::create([
            'nama' => 'Sekretaris Umum MPM-KEMA-POLSUB',
            'username' => 'Sekretaris-Umum-MPM-KEMA-POLSUB',
            'nim' => '201524051',
            'password' => bcrypt('admin123'),
            'role' => 'sekretaris_umum',
            'ormawa_id' => 1
        ]);

        // 4
        User::create([
            'nama' => 'Sekretaris Proker MPM-KEMA-POLSUB',
            'username' => 'Sekretaris-Proker-MPM-KEMA-POLSUB',
            'nim' => '201524052',
            'password' => bcrypt('admin123'),
            'role' => 'sekretaris_proker',
            'ormawa_id' => 1
        ]);

        // 5
        User::create([
            'nama' => 'Pembina MPM-KEMA-POLSUB',
            'username' => 'Pembina-MPM-KEMA-POLSUB',
            'nim' => '201524053',
            'password' => bcrypt('admin123'),
            'role' => 'pembina',
            'ormawa_id' => 1
        ]);

        // 6
        User::create([
            'nama' => 'Ketua BEM-KEMA-POLSUB',
            'username' => 'Ketua-BEM-KEMA-POLSUB',
            'nim' => '201524054',
            'password' => bcrypt('admin123'),
            'role' => 'ketua',
            'ormawa_id' => 2
        ]);

        // 7
        User::create([
            'nama' => 'Sekretaris Umum BEM-KEMA-POLSUB',
            'username' => 'Sekretaris-Umum-BEM-KEMA-POLSUB',
            'nim' => '201524055',
            'password' => bcrypt('admin123'),
            'role' => 'sekretaris_umum',
            'ormawa_id' => 2
        ]);

        // 8
        User::create([
            'nama' => 'Sekretaris Proker BEM-KEMA-POLSUB',
            'username' => 'Sekretaris-Proker-BEM-KEMA-POLSUB',
            'nim' => '201524056',
            'password' => bcrypt('admin123'),
            'role' => 'sekretaris_proker',
            'ormawa_id' => 2
        ]);

        // 9
        User::create([
            'nama' => 'Pembina BEM-KEMA-POLSUB',
            'username' => 'Pembina-BEM-KEMA-POLSUB',
            'nim' => '201524057',
            'password' => bcrypt('admin123'),
            'role' => 'pembina',
            'ormawa_id' => 2
        ]);

        // 10
        User::create([
            'nama' => 'Anggota MPM-KEMA-POLSUB',
            'username' => 'Anggota-MPM-KEMA-POLSUB',
            'nim' => '201524058',
            'password' => bcrypt('admin123'),
            'role' => 'anggota',
            'ormawa_id' => 1
        ]);

        // 11
        User::create([
            'nama' => 'Ketua Informatika',
            'username' => 'Ketua-Informatika',
            'nim' => '201524020',
            'password' => bcrypt('admin123'),
            'role' => 'ketua',
            'ormawa_id' => 3
        ]);

        // 12
        User::create([
            'nama' => 'Sekretaris Umum Informatika',
            'username' => 'Sekretaris-Informatika',
            'nim' => '201524021',
            'password' => bcrypt('admin123'),
            'role' => 'sekretaris_umum',
            'ormawa_id' => 3
        ]);

        // 13
        User::create([
            'nama' => 'Sekretaris Proker Informatika',
            'username' => 'Sekretaris-Proker-Informatika',
            'nim' => '201524022',
            'password' => bcrypt('admin123'),
            'role' => 'sekretaris_proker',
            'ormawa_id' => 3
        ]);

        // 14
        User::create([
            'nama' => 'Pembina Informatika',
            'username' => 'Pembina-Informatika',
            'nim' => '201524023',
            'password' => bcrypt('admin123'),
            'role' => 'pembina',
            'ormawa_id' => 3
        ]);

        // 15
        User::create([
            'nama' => 'Ketua Badminton',
            'username' => 'Ketua-Badminton',
            'nim' => '201524024',
            'password' => bcrypt('admin123'),
            'role' => 'ketua',
            'ormawa_id' => 4
        ]);

        // 16
        User::create([
            'nama' => 'Sekretaris Umum Badminton',
            'username' => 'Sekretaris-Badminton',
            'nim' => '201524025',
            'password' => bcrypt('admin123'),
            'role' => 'sekretaris_umum',
            'ormawa_id' => 4
        ]);

        // 17
        User::create([
            'nama' => 'Sekretaris Proker Badminton',
            'username' => 'Sekretaris-Proker-Badminton',
            'nim' => '201524026',
            'password' => bcrypt('admin123'),
            'role' => 'sekretaris_proker',
            'ormawa_id' => 4
        ]);

        // 18
        User::create([
            'nama' => 'Pembina Badminton',
            'username' => 'Pembina-Badminton',
            'nim' => '201524027',
            'password' => bcrypt('admin123'),
            'role' => 'pembina',
            'ormawa_id' => 4
        ]);

        // 19
        User::create([
            'nama' => 'Wadir Polsub',
            'username' => 'wadir-polsub',
            'password' => bcrypt('admin123'),
            'role' => 'wadir',
        ]);
    }
}
