<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(LaratrustSeeder::class);
        $this->call(AdminUserSeeder::class);
        $this->call(SemesterSeeder::class);
        $this->call(KategoriKegiatanSeeder::class);
        $this->call(JenisKegiatanSeeder::class);
        $this->call(AngkatanSeeder::class);
        $this->call(SetupSeeder::class);
    }
}
