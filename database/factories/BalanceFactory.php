<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Balance;
use App\Models\Cliente;
use App\Models\TipoBalance;
use App\Models\User;
use App\Models\Venta;

class BalanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Balance::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'saldo_actual' => $this->faker->randomFloat(0, 0, 9999999999.),
            'saldo_final' => $this->faker->randomFloat(0, 0, 9999999999.),
            'descripcion' => $this->faker->text,
            'precio' => $this->faker->randomFloat(0, 0, 9999999999.),
            'balance_id' => Balance::factory(),
            'tipo_balance_id' => TipoBalance::factory(),
            'user_id' => User::factory(),
            'cliente_id' => Cliente::factory(),
            'venta_id' => Venta::factory(),
        ];
    }
}
