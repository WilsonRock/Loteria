<?php

namespace Database\Factories;

use App\Models\Nodes;
use Illuminate\Database\Eloquent\Factories\Factory;

class NodesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Nodes::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type_node_id' => '1'
        ];
    }
}
