<?php

namespace Database\Seeders;

use App\Models\Entities;
use App\Models\Nodes;
use App\Models\TypeNodes;
use App\Models\User;
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
        TypeNodes::create([
            'name' => 'Entidad'
        ]);
        TypeNodes::create([
            'name' => 'Juego'
        ]);

        Nodes::factory()->create();

        Entities::factory()->create();

        User::factory([
            'email' => 'email@email.com'
        ])->create();
    }
}
