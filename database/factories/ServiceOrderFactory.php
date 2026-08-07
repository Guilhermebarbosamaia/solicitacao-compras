<?php

namespace Database\Factories;

use App\Models\ServiceOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceOrderFactory extends Factory
{
    protected $model = ServiceOrder::class;

    public function definition(): array
    {
        return [
            'code' => 'OS-' . $this->faker->unique()->numberBetween(100, 999),
            'description' => $this->faker->sentence(4),
            'status' => $this->faker->randomElement(['pending', 'approved', 'completed']),
        ];
    }
}
