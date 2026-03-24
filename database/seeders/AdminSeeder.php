<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Petugas',
            'email' => 'petugas@test.com',
            'password' => bcrypt('password123'),
            'role' => 'petugas',
        ]);

        User::create([
            'name' => 'Peminjam',
            'email' => 'user@test.com',
            'password' => bcrypt('password123'),
            'role' => 'peminjam',
        ]);
    }
}
