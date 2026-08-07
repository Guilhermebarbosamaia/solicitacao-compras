<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-semibold">Visualizar solicitação</h1>
            <p class="text-slate-600">Detalhes da solicitação, ordens de pagamento e parcelas.</p>
        </div>
        <a href="/purchase-requests/{{ $purchaseRequest->id }}/payment-orders" class="rounded bg-slate-900 px-4 py-2 text-white hover:bg-slate-700">Nova ordem de pagamento</a>
    </div>

    <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <p class="text-sm text-slate-500">Descrição</p>
                <p class="font-medium">{{ $purchaseRequest->description }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500">Status</p>
                <p class="font-medium capitalize">{{ $purchaseRequest->status }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500">Valor estimado</p>
                <p class="font-medium">R$ {{ number_format($purchaseRequest->estimated_value, 2, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500">Ordem de serviço</p>
                <p class="font-medium">{{ $purchaseRequest->serviceOrder?->code ?? 'Sem ordem de serviço' }}</p>
            </div>
        </div>
    </div>

    <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-xl font-semibold">Ordens de pagamento</h2>
        @forelse($purchaseRequest->paymentOrders as $paymentOrder)
            <div class="mt-4 rounded border border-slate-200 p-4">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <div>
                        <p class="font-medium">{{ $paymentOrder->description }}</p>
                        <p class="text-sm text-slate-500">Tipo: {{ $paymentOrder->payment_type === 'cash' ? 'À vista' : 'Parcelado' }} | Status: {{ $paymentOrder->status }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold">R$ {{ number_format($paymentOrder->total_amount, 2, ',', '.') }}</p>
                        <p class="text-sm text-slate-500">Vencimento: {{ $paymentOrder->due_date->format('d/m/Y') }}</p>
                    </div>
                </div>

                @if($paymentOrder->installments->isNotEmpty())
                    <div class="mt-4 rounded bg-slate-50 p-3">
                        <p class="mb-2 font-medium">Parcelas</p>
                        <ul class="space-y-2 text-sm">
                            @foreach($paymentOrder->installments as $installment)
                                <li class="flex items-center justify-between rounded border border-slate-200 bg-white px-3 py-2">
                                    <span>Parcela {{ $installment->installment_number }}</span>
                                    <span>R$ {{ number_format($installment->amount, 2, ',', '.') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        @empty
            <p class="mt-4 text-slate-500">Nenhuma ordem de pagamento cadastrada para esta solicitação.</p>
        @endforelse
    </div>
</div>
