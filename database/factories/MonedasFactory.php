<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Monedas;
use App\Models\Pais;

class MonedasFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Monedas::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'codigo' => $this->faker->word,
            'nombre' => $this->faker->word,
            'simbolo' => $this->faker->word,
            'pais_id' => Pais::factory(),
        ];
    }
}
