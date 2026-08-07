<?php

namespace Database\Factories;

use App\Models\Installment;
use App\Models\PaymentOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstallmentFactory extends Factory
{
    protected $model = Installment::class;

    public function definition(): array
    {
        return [
            'payment_order_id' => PaymentOrder::factory(),
            'installment_number' => 1,
            'amount' => 100.00,
            'due_date' => $this->faker->dateTimeBetween('now', '+2 months')->format('Y-m-d'),
            'status' => 'pending',
        ];
    }
}
