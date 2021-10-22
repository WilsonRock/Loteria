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
        $type_nodes = \App\Models\TypeNodes::factory()->create();

        $nodes = \App\Models\Nodes::factory()->create();

        $user = \App\Models\User::factory([
            'email' => 'email@email.com'
        ])->create();
    }
}
