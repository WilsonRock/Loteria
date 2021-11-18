<?php

namespace Database\Seeders;

use App\Models\Entities;
use App\Models\Nodes;
use App\Models\TypeNodes;
use App\Models\User;
use Illuminate\Support\Str;
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

        /* Nodes::factory()->create(); */
        Nodes::create([
            'type_node_id' => '1'
        ]);

        /* Entities::factory()->create(); */
        Entities::create([
            'node_id' => 1,
            'zona_horaria' => 'GMT-5',
            'moneda' => 'COP',
            'nombre_contacto' => 'Principal',
            'telefono_contacto' => '3111111111',
            'email' => 'email@email.com',
            'pais' => 'COL',
            'zona' => 'Meta',
            'nit' => '911111111',
            'balance' => '500000'
        ]);

        /* User::factory([
            'email' => 'email@email.com'
        ])->create(); */
        User::create([
            'nombres' => 'Demarcus',
            'apellidos' => 'Mills',
            'documento' => 'corporis',
            'telefono' => '1-234-850-6841',
            'email' => 'email@email.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'node_id' => 1,
            'tipo_usuario' => 'vendedor'
        ]);
    }
}
