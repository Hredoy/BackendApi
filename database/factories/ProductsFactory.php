<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use app\Models\Products;

class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Products::class;
    public function definition()
    {
        return [
            'name' => $this->faker->text,
            'description' => $this->faker->text,
            'image' => "documents/fUInzviK6q99CxvbUpCjpnrwKEIacOKYEGD9aHlr.jpg",
            'price' => rand(100, 999),
            'qty' => rand(100, 999),
        ];
    }
}
