<?php

namespace Database\Seeders;

use App\Models\Role;
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
        Role::create(['name' => 'Super Admin']);
        $user = \App\Models\User::factory([
            'email' => 'email@email.com'
        ])->create();
        $user->assignRole('Super Admin');

        $plazas = \App\Models\Plaza::factory()->times(5)->create();
    }
}
