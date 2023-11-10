<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{

    protected $model = Product::class;

    protected $quantity;
    protected $price;


    public function definition()
    {
        return [
            //
            'name' => $this->faker->name,
            'cases' => $this->faker->randomNumber,
            'reference_number' => $this->faker->slug,
            'slug' => $this->faker->slug,
            'description' => $this->faker->paragraph,
            'quantity' => $this->quantity,
            'price' => $this->price,
            
        ];
    }
}
