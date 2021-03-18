<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ConfiguracionJuego;
use App\Models\Estado;
use App\Models\Municipio;
use App\Models\TipoJuego;

class ConfiguracionJuegoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ConfiguracionJuego::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->word,
            'descripcion' => $this->faker->word,
            'valor_boleto' => $this->faker->randomFloat(0, 0, 9999999999.),
            'cantidad_boletos' => $this->faker->numberBetween(-10000, 10000),
            'cifras' => $this->faker->numberBetween(-10000, 10000),
            'premio' => $this->faker->randomFloat(0, 0, 9999999999.),
            'terminos' => $this->faker->text,
            'tipo_juego_id' => TipoJuego::factory(),
            'municipio_id' => Municipio::factory(),
            'estado_id' => Estado::factory(),
        ];
    }
}
