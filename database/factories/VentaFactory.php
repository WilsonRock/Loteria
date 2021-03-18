<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\IdCliente;
use App\Models\Venta;

class VentaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Venta::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fecha_venta' => $this->faker->dateTime(),
            'boletos' => '{}',
            'precio' => $this->faker->randomFloat(0, 0, 9999999999.),
            'id_cliente' => IdCliente::factory(),
        ];
    }
}
