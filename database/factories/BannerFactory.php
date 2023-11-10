<?php

namespace Database\Factories;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Banner>
 */
class BannerFactory extends Factory
{

    protected $model = Banner::class;

    public function definition(): array
    {
        return [
            //
            'name' => $this->faker->name,
            'slug' => $this->faker->slug,
        ];
    }
}
