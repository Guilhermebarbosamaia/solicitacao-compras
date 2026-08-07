<?php

namespace App\Http\Livewire;

use App\Models\PurchaseRequest;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PaymentOrderManager extends Component
{
    public PurchaseRequest $purchaseRequest;

    public string $description = '';

    public string $payment_type = 'cash';

    public string $total_amount = '';

    public string $due_date = '';

    public string $status = 'pending';

    public array $installments = [];

    public function mount(PurchaseRequest $purchaseRequest): void
    {
        $this->purchaseRequest = $purchaseRequest;
    }

    public function addInstallment(): void
    {
        $this->installments[] = [
            'installment_number' => count($this->installments) + 1,
            'amount' => '',
            'due_date' => '',
            'status' => 'pending',
        ];
    }

    public function save(): void
    {
        $validated = $this->validate([
            'description' => 'required|string|max:255',
            'payment_type' => 'required|in:cash,installment',
            'total_amount' => 'required|numeric|min:0.01',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,approved,rejected,completed',
            'installments' => 'nullable|array',
            'installments.*.installment_number' => 'required|integer|min:1',
            'installments.*.amount' => 'required|numeric|min:0.01',
            'installments.*.due_date' => 'required|date',
            'installments.*.status' => 'required|in:pending,approved,rejected,completed',
        ], [
            'description.required' => 'A descrição é obrigatória.',
            'payment_type.required' => 'O tipo de pagamento é obrigatório.',
            'total_amount.required' => 'Informe o valor total.',
            'total_amount.numeric' => 'Informe um valor numérico válido para o valor total.',
            'due_date.required' => 'Informe a data de vencimento.',
            'status.required' => 'O status é obrigatório.',
            'installments.*.installment_number.required' => 'O número da parcela é obrigatório.',
            'installments.*.amount.required' => 'O valor da parcela é obrigatório.',
            'installments.*.amount.numeric' => 'Informe um valor numérico válido para a parcela.',
            'installments.*.due_date.required' => 'A data de vencimento da parcela é obrigatória.',
            'installments.*.status.required' => 'O status da parcela é obrigatório.',
        ]);

        if ($validated['payment_type'] === 'installment') {
            $installmentTotal = collect($validated['installments'])->sum('amount');
            if (round($installmentTotal, 2) !== round((float) $validated['total_amount'], 2)) {
                session()->flash('error', 'O somatório das parcelas deve coincidir com o valor total da ordem de pagamento.');
                return;
            }
        }

        DB::transaction(function () use ($validated) {
            $paymentOrder = $this->purchaseRequest->paymentOrders()->create([
                'description' => $validated['description'],
                'payment_type' => $validated['payment_type'],
                'total_amount' => $validated['total_amount'],
                'due_date' => $validated['due_date'],
                'status' => $validated['status'],
            ]);

            if ($validated['payment_type'] === 'installment') {
                foreach ($validated['installments'] as $installmentData) {
                    $paymentOrder->installments()->create([
                        'installment_number' => $installmentData['installment_number'],
                        'amount' => $installmentData['amount'],
                        'due_date' => $installmentData['due_date'],
                        'status' => $installmentData['status'],
                    ]);
                }
            }
        });

        session()->flash('success', 'Ordem de pagamento criada com sucesso.');
        $this->reset(['description', 'payment_type', 'total_amount', 'due_date', 'status', 'installments']);
        $this->dispatch('$refresh');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.payment-order-manager');
    }
}
