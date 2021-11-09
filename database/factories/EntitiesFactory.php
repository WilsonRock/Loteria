<?php

namespace Database\Factories;

use App\Models\Entities;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntitiesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Entities::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
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
        ];
    }
}
