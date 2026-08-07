<?php

namespace Tests\Feature;

use App\Models\PaymentOrder;
use App\Models\PurchaseRequest;
use App\Models\ServiceOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseRequestFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_purchase_request_can_be_created_with_related_service_order_and_payment_orders(): void
    {
        $serviceOrder = ServiceOrder::factory()->create();
        $purchaseRequest = PurchaseRequest::factory()->create([
            'service_order_id' => $serviceOrder->id,
        ]);

        $paymentOrder = $purchaseRequest->paymentOrders()->create([
            'description' => 'Pagamento de material',
            'payment_type' => 'cash',
            'total_amount' => 150.00,
            'due_date' => now()->addDay()->toDateString(),
            'status' => 'pending',
        ]);

        $paymentOrder->installments()->create([
            'installment_number' => 1,
            'amount' => 150.00,
            'due_date' => now()->addDay()->toDateString(),
            'status' => 'pending',
        ]);

        $this->assertNotNull($purchaseRequest->fresh()->serviceOrder);
        $this->assertTrue($purchaseRequest->paymentOrders()->exists());
        $this->assertTrue($paymentOrder->installments()->exists());
    }

    public function test_installment_total_must_match_payment_total(): void
    {
        $paymentOrder = new PaymentOrder([
            'payment_type' => 'installment',
            'total_amount' => 100.00,
        ]);

        $this->assertTrue($paymentOrder->hasValidInstallmentTotal([50.00, 50.00]));
        $this->assertFalse($paymentOrder->hasValidInstallmentTotal([40.00, 50.00]));
    }
}
