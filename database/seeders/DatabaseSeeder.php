<?php

namespace Database\Seeders;

use App\Models\TbAreaParkir;
use App\Models\TbTarif;
use App\Models\TbUser;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            [
                'nama_user' => 'Administrator',
                'username' => 'admin',
                'email' => 'admin@parkir.test',
                'role' => 'admin',
            ],
            [
                'nama_user' => 'Petugas Parkir',
                'username' => 'petugas',
                'email' => 'petugas@parkir.test',
                'role' => 'petugas',
            ],
            [
                'nama_user' => 'Owner',
                'username' => 'owner',
                'email' => 'owner@parkir.test',
                'role' => 'owner',
            ],
        ] as $user) {
            TbUser::updateOrCreate(
                ['username' => $user['username']],
                [...$user, 'password' => 'password', 'status_aktif' => true],
            );
        }

        foreach ([
            ['jenis_kendaraan' => 'motor', 'tarif_per_jam' => 2000, 'tarif_maksimal' => 20000],
            ['jenis_kendaraan' => 'mobil', 'tarif_per_jam' => 5000, 'tarif_maksimal' => 50000],
        ] as $tarif) {
            TbTarif::updateOrCreate(
                ['jenis_kendaraan' => $tarif['jenis_kendaraan']],
                [...$tarif, 'status_aktif' => true],
            );
        }

        foreach ([
            ['nama_area' => 'Area Motor', 'jenis_kendaraan' => 'motor', 'kapasitas' => 100],
            ['nama_area' => 'Area Mobil', 'jenis_kendaraan' => 'mobil', 'kapasitas' => 50],
        ] as $area) {
            TbAreaParkir::updateOrCreate(
                ['nama_area' => $area['nama_area']],
                [...$area, 'status_aktif' => true],
            );
        }
    }
}
