<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Prefecture;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'prefecture_id' => Prefecture::factory(),
            'code' => $this->faker->unique()->numberBetween(10000, 99999),
            'name' => $this->faker->city,
        ];
    }
}
