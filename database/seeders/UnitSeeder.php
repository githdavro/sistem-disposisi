<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run()
    {
        $units = [
            ['nama_unit' => 'Teknologi Informasi', 'kode_unit' => 'TI'],
            ['nama_unit' => 'Keuangan', 'kode_unit' => 'KEU'],
            ['nama_unit' => 'Sumber Daya Manusia', 'kode_unit' => 'SDM'],
            ['nama_unit' => 'Pemasaran', 'kode_unit' => 'PMK'],
            ['nama_unit' => 'Operasional', 'kode_unit' => 'OPS'],
            ['nama_unit' => 'Pengadaan', 'kode_unit' => 'PENG'],
            ['nama_unit' => 'Direksi', 'kode_unit' => 'DIR'],
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
}