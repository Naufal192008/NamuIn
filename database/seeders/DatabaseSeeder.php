<?php

namespace Database\Seeders;

use App\Models\KategoriTamu;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@namuin.id'],
            ['name' => 'Admin NamuIn', 'role' => 'admin', 'password' => Hash::make('password')]
        );

        $kategoris = [
            ['nama_kategori' => 'Wali Murid',  'warna' => '#f59e0b'],
            ['nama_kategori' => 'Dinas',        'warna' => '#3b82f6'],
            ['nama_kategori' => 'Vendor',       'warna' => '#8b5cf6'],
            ['nama_kategori' => 'Tamu Umum',    'warna' => '#6b7280'],
            ['nama_kategori' => 'Orang Tua',    'warna' => '#10b981'],
        ];

        foreach ($kategoris as $k) {
            KategoriTamu::firstOrCreate(['nama_kategori' => $k['nama_kategori']], $k);
        }
    }
}
