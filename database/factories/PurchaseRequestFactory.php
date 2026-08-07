<?php

namespace Database\Factories;

use App\Models\PurchaseRequest;
use App\Models\ServiceOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseRequestFactory extends Factory
{
    protected $model = PurchaseRequest::class;

    public function definition(): array
    {
        return [
            'description' => $this->faker->sentence(6),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected', 'completed']),
            'estimated_value' => $this->faker->randomFloat(2, 100, 5000),
            'service_order_id' => ServiceOrder::factory(),
        ];
    }
}
