<?php

namespace Database\Factories;

use App\Models\PaymentOrder;
use App\Models\PurchaseRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentOrderFactory extends Factory
{
    protected $model = PaymentOrder::class;

    public function definition(): array
    {
        return [
            'purchase_request_id' => PurchaseRequest::factory(),
            'description' => $this->faker->sentence(4),
            'payment_type' => $this->faker->randomElement(['cash', 'installment']),
            'total_amount' => $this->faker->randomFloat(2, 50, 1000),
            'due_date' => $this->faker->dateTimeBetween('now', '+2 months')->format('Y-m-d'),
            'status' => 'pending',
        ];
    }
}
