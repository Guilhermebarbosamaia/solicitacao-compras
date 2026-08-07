<?php

namespace App\Http\Livewire;

use App\Models\PurchaseRequest;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class PurchaseRequestList extends Component
{
    use WithPagination;

    public string $search = '';

    public string $status = '';

    public function delete(PurchaseRequest $purchaseRequest): void
    {
        $purchaseRequest->delete();
        session()->flash('success', 'Solicitação removida com sucesso.');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $purchaseRequests = PurchaseRequest::query()
            ->with(['serviceOrder', 'paymentOrders'])
            ->when($this->search !== '', function ($query) {
                $query->where('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->status !== '', function ($query) {
                $query->where('status', $this->status);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.purchase-request-list', compact('purchaseRequests'));
    }
}
