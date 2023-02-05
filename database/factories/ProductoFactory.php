<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    // 'codigo',
    //     'nombre',
    //     'descripcion',
    //     'precio',
    //     'imagen',
    //     'like',
    //     'dislike',
    //     'user_id',
    public function definition()
    {
        return [
            'codigo' => $this->faker->unique()->numberBetween(1000, 9999),
            'nombre' => $this->faker->name(),
            'descripcion' => $this->faker->text(),
            'precio' => $this->faker->randomNumber(2),
            'imagen' => $this->faker->imageUrl(5, 10),
            'like' => rand(0,10),
            'dislike' => rand(0,10),

        ];
    }
}
