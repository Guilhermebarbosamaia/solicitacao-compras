<?php

namespace App\Http\Livewire;

use App\Models\PurchaseRequest;
use App\Models\ServiceOrder;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PurchaseRequestForm extends Component
{
    public ?PurchaseRequest $purchaseRequest = null;

    public string $description = '';

    public string $status = 'pending';

    public string $estimated_value = '';

    public ?int $service_order_id = null;

    public array $serviceOrders = [];

    public bool $isEditing = false;

    public function mount(?PurchaseRequest $purchaseRequest = null): void
    {
        $this->serviceOrders = ServiceOrder::query()->orderBy('code')->pluck('code', 'id')->toArray();

        if ($purchaseRequest) {
            $this->isEditing = true;
            $this->purchaseRequest = $purchaseRequest;
            $this->description = $purchaseRequest->description;
            $this->status = $purchaseRequest->status;
            $this->estimated_value = (string) $purchaseRequest->estimated_value;
            $this->service_order_id = $purchaseRequest->service_order_id;
        }
    }

    public function save(): void
    {
        $validated = $this->validate([
            'description' => 'required|string|max:255',
            'status' => 'required|in:pending,approved,rejected,completed',
            'estimated_value' => 'required|numeric|min:0.01',
            'service_order_id' => 'nullable|exists:ordens_servico,id',
        ], [
            'description.required' => 'A descrição é obrigatória.',
            'status.required' => 'O status é obrigatório.',
            'estimated_value.required' => 'O valor estimado é obrigatório.',
            'estimated_value.numeric' => 'Informe um valor numérico válido.',
            'estimated_value.min' => 'O valor estimado precisa ser maior que zero.',
        ]);

        if ($this->purchaseRequest) {
            $this->purchaseRequest->update($validated);
            session()->flash('success', 'Solicitação atualizada com sucesso.');
        } else {
            PurchaseRequest::create($validated);
            session()->flash('success', 'Solicitação cadastrada com sucesso.');
        }

        $this->redirect('/purchase-requests', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.purchase-request-form');
    }
}
