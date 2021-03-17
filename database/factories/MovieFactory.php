<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Movie::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'description' => $this->faker->paragraph,
            'stock' => rand(0, 1000),
            'rental_price' => rand(0, 10000),
            'sale_price' => rand(0, 10000),
            'availability' => rand(0, 1),
        ];
    }
}
