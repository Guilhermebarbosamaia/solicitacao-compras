<?php

namespace App\Http\Livewire;

use App\Models\PurchaseRequest;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PurchaseRequestShow extends Component
{
    public PurchaseRequest $purchaseRequest;

    public function mount(PurchaseRequest $purchaseRequest): void
    {
        $this->purchaseRequest = $purchaseRequest->load(['serviceOrder', 'paymentOrders.installments']);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.purchase-request-show');
    }
}
