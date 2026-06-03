<?php

namespace Database\Seeders;

use App\Models\KategoriTamu;
use App\Models\Pegawai;
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

        User::firstOrCreate(
            ['email' => 'resepsionis@namuin.id'],
            ['name' => 'Randi Resepsionis', 'role' => 'receptionist', 'password' => Hash::make('password')]
        );

        $kategoris = [
            ['nama_kategori' => 'Wali Murid',  'warna' => '#f59e0b'],
            ['nama_kategori' => 'Dinas',        'warna' => '#3b82f6'],
            ['nama_kategori' => 'Vendor',       'warna' => '#8b5cf6'],
            ['nama_kategori' => 'Tamu Umum',    'warna' => '#71717A'],
            ['nama_kategori' => 'Orang Tua',    'warna' => '#10b981'],
        ];

        foreach ($kategoris as $k) {
            KategoriTamu::firstOrCreate(['nama_kategori' => $k['nama_kategori']], $k);
        }

        $pegawais = [
            ['nama' => 'Drs. Ahmad Fauzi, M.Pd', 'nip' => '196501011990031001', 'jabatan' => 'Kepala Sekolah',    'departemen' => 'Pimpinan',       'no_wa' => '081200000001', 'email' => 'kepsek@smkn1.sch.id'],
            ['nama' => 'Siti Rahayu, S.Pd',       'nip' => '197203152000122001', 'jabatan' => 'Waka Kurikulum',   'departemen' => 'Kurikulum',      'no_wa' => '081200000002', 'email' => 'kurikulum@smkn1.sch.id'],
            ['nama' => 'Budi Santoso, S.E',        'nip' => '198004202005011002', 'jabatan' => 'Waka Kesiswaan',  'departemen' => 'Kesiswaan',      'no_wa' => '081200000003', 'email' => 'kesiswaan@smkn1.sch.id'],
            ['nama' => 'Dewi Kusuma, S.Kom',       'nip' => '198509112010012003', 'jabatan' => 'Guru RPL',         'departemen' => 'RPL',            'no_wa' => '081200000004', 'email' => 'dewi@smkn1.sch.id'],
            ['nama' => 'Hendra Wijaya, S.T',       'nip' => '199001202015031004', 'jabatan' => 'Guru TKJ',         'departemen' => 'TKJ',            'no_wa' => '081200000005', 'email' => 'hendra@smkn1.sch.id'],
            ['nama' => 'Rina Marlina, S.Pd',       'nip' => null,                 'jabatan' => 'Staff TU',         'departemen' => 'Tata Usaha',     'no_wa' => '081200000006', 'email' => 'tu@smkn1.sch.id'],
            ['nama' => 'Agus Setiawan, S.Pd',      'nip' => '198812052012011005', 'jabatan' => 'Guru BK',          'departemen' => 'BK',             'no_wa' => '081200000007', 'email' => 'bk@smkn1.sch.id'],
        ];

        foreach ($pegawais as $p) {
            Pegawai::firstOrCreate(['no_wa' => $p['no_wa']], $p + ['aktif' => true]);
        }
    }
}
