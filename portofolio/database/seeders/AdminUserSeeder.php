<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => "Super Admin",
            'email' => 'super.admin@porto.id',
            'password' => bcrypt('password'),
        ]);
        $user->attachRole("admin");
    }
}
