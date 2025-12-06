<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'Admin Cashmit',
            'email' => 'admin@cashmit.com',
            'nim_nip' => 'admin001',
            'password' => bcrypt('12345678'),
            'role' => 'admin',
            'status' => 'active',
        ]);
        User::create([
            'nama' => 'Petugas Cashmit',
            'email' => 'petugas@cashmit.com',
            'nim_nip' => 'petugas001',
            'password' => bcrypt('12345678'),
            'role' => 'petugas',
            'status' => 'active',
        ]);
        User::create([
            'nama' => 'Customer Cashmit',
            'email' => 'customer@cashmit.com',
            'nim_nip' => 'customer001',
            'password' => bcrypt('12345678'),
            'role' => 'customer',
            'status' => 'active',
        ]);
    }
}
