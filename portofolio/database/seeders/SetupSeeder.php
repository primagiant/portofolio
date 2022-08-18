<?php

namespace Database\Seeders;

use App\Models\Fakultas;
use App\Models\Jurusan;
use App\Models\Prodi;
use Illuminate\Database\Seeder;

class SetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fakultas = Fakultas::create([
            'nama_fakultas' => "Fakultas Teknik dan Kejuruan",
            'deskripsi' => 'FTK',
        ]);

        $jurusan = Jurusan::create([
            'nama_jurusan' => 'Teknik Informatika',
            'fakultas_id' => $fakultas->id,
            'deskripsi' => "IT"
        ]);

        Prodi::create([
            'nama_prodi' => 'Ilmu Komputer',
            'fakultas_id' => $fakultas->id,
            'jurusan_id' => $jurusan->id,
            'deskripsi' => "ILKOM",
        ]);
    }
}
