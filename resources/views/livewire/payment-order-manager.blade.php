<div class="max-w-4xl space-y-6">
    <div>
        <h1 class="text-3xl font-semibold">Gerenciar ordens de pagamento</h1>
        <p class="text-slate-600">Cadastre uma ordem de pagamento à vista ou parcelada para esta solicitação.</p>
    </div>

    @if (session()->has('success'))
        <div class="rounded border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
    @endif

    @if (session()->has('error'))
        <div class="rounded border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{{ session('error') }}</div>
    @endif

    <form wire:submit="save" class="space-y-4 rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <div class="grid gap-4 md:grid-cols-2">
            <div class="md:col-span-2">
                <label class="mb-1 block text-sm font-medium">Descrição</label>
                <input type="text" wire:model="description" class="w-full rounded border border-slate-300 px-3 py-2" />
                @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium">Tipo de pagamento</label>
                <select wire:model="payment_type" class="w-full rounded border border-slate-300 px-3 py-2">
                    <option value="cash">À vista</option>
                    <option value="installment">Parcelado</option>
                </select>
                @error('payment_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium">Valor total</label>
                <input type="number" step="0.01" wire:model="total_amount" class="w-full rounded border border-slate-300 px-3 py-2" />
                @error('total_amount') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium">Data de vencimento</label>
                <input type="date" wire:model="due_date" class="w-full rounded border border-slate-300 px-3 py-2" />
                @error('due_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium">Status</label>
                <select wire:model="status" class="w-full rounded border border-slate-300 px-3 py-2">
                    <option value="pending">Pendente</option>
                    <option value="approved">Aprovado</option>
                    <option value="rejected">Rejeitado</option>
                    <option value="completed">Concluído</option>
                </select>
                @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        @if($payment_type === 'installment')
            <div class="rounded border border-slate-200 bg-slate-50 p-4">
                <div class="mb-3 flex items-center justify-between">
                    <h2 class="font-medium">Parcelas</h2>
                    <button type="button" wire:click="addInstallment" class="rounded bg-slate-900 px-3 py-2 text-sm text-white">Adicionar parcela</button>
                </div>

                @foreach($installments as $index => $installment)
                    <div class="mb-3 grid gap-3 rounded border border-slate-200 bg-white p-3 md:grid-cols-3">
                        <div>
                            <label class="mb-1 block text-sm">Parcela</label>
                            <input type="number" wire:model="installments.{{ $index }}.installment_number" class="w-full rounded border border-slate-300 px-3 py-2" />
                        </div>
                        <div>
                            <label class="mb-1 block text-sm">Valor</label>
                            <input type="number" step="0.01" wire:model="installments.{{ $index }}.amount" class="w-full rounded border border-slate-300 px-3 py-2" />
                        </div>
                        <div>
                            <label class="mb-1 block text-sm">Vencimento</label>
                            <input type="date" wire:model="installments.{{ $index }}.due_date" class="w-full rounded border border-slate-300 px-3 py-2" />
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="flex gap-3">
            <button type="submit" class="rounded bg-slate-900 px-4 py-2 text-white hover:bg-slate-700">Salvar ordem</button>
            <a href="/purchase-requests/{{ $purchaseRequest->id }}" class="rounded border border-slate-300 px-4 py-2 text-slate-700">Voltar</a>
        </div>
    </form>
</div>
