<?php

namespace Database\Seeders;

use App\Models\PaymentOrder;
use App\Models\PurchaseRequest;
use App\Models\ServiceOrder;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $serviceOrders = ServiceOrder::factory(3)->create();

        foreach ($serviceOrders as $serviceOrder) {
            PurchaseRequest::factory(2)->create([
                'service_order_id' => $serviceOrder->id,
            ])->each(function (PurchaseRequest $purchaseRequest) {
                $paymentOrder = PaymentOrder::factory()->create([
                    'purchase_request_id' => $purchaseRequest->id,
                    'payment_type' => 'cash',
                    'total_amount' => 250.00,
                ]);

                $paymentOrder->installments()->create([
                    'installment_number' => 1,
                    'amount' => 250.00,
                    'due_date' => now()->addDay()->toDateString(),
                    'status' => 'pending',
                ]);
            });
        }

        $withoutServiceOrder = PurchaseRequest::factory(2)->create([
            'service_order_id' => null,
        ]);

        foreach ($withoutServiceOrder as $purchaseRequest) {
            $paymentOrder = PaymentOrder::factory()->create([
                'purchase_request_id' => $purchaseRequest->id,
                'payment_type' => 'installment',
                'total_amount' => 600.00,
            ]);

            $paymentOrder->installments()->createMany([
                [
                    'installment_number' => 1,
                    'amount' => 300.00,
                    'due_date' => now()->addMonth()->toDateString(),
                    'status' => 'pending',
                ],
                [
                    'installment_number' => 2,
                    'amount' => 300.00,
                    'due_date' => now()->addMonths(2)->toDateString(),
                    'status' => 'pending',
                ],
            ]);
        }
    }
}
