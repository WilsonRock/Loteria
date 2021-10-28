<?php

namespace Database\Factories;

use App\Models\TypeNodes;
use Illuminate\Database\Eloquent\Factories\Factory;

class TypeNodesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TypeNodes::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->randomElement(['Entidad', 'Juego'])
        ];
    }
}
