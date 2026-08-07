<?php

namespace App\Http\Livewire;

use App\Models\PaymentOrder;
use App\Models\PurchaseRequest;
use App\Models\ServiceOrder;
use Livewire\Attributes\Layout;
use Livewire\Component;

class HomeDashboard extends Component
{
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.home-dashboard', [
            'purchaseRequestsCount' => PurchaseRequest::count(),
            'serviceOrdersCount' => ServiceOrder::count(),
            'paymentOrdersCount' => PaymentOrder::count(),
            'pendingPurchases' => PurchaseRequest::where('status', 'pending')->count(),
        ]);
    }
}
