<?php

namespace Database\Seeders;

use App\Models\Nodes;
use App\Models\TypeNodes;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    function combination($size, $elements)
    {
        if ($size > 0) {
            $combinations = array();
            $res = $this->combination($size - 1, $elements);
            foreach ($res as $ce) {
                foreach ($elements as $e) {
                    array_Push($combinations, $ce . $e);
                }
            }
            return $combinations;
        } else {
            return array('');
        }
    }
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

        User::factory([
            'email' => 'email@email.com'
        ])->create();
    }
}
