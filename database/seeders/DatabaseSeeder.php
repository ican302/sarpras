<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'nip' => '123456789',
            'password' => bcrypt('password123'),
            'nama_pengguna' => 'Agus',
            'posisi' => 'Ketua Sarpras',
            'tugas' => 'Managing Data',
            'role' => 'Admin',
            'foto' => 'foto_pengguna/default.png',
        ]);
    }
}
