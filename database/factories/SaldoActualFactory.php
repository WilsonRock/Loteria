<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\SaldoActual;
use App\Models\User;

class SaldoActualFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SaldoActual::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'saldo' => $this->faker->randomFloat(0, 0, 9999999999.),
            'deuda' => $this->faker->randomFloat(0, 0, 9999999999.),
            'user_id' => User::factory(),
        ];
    }
}
