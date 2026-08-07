<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-semibold">Solicitações de compra</h1>
            <p class="text-slate-600">Liste, visualize e gerencie solicitações e pagamentos.</p>
        </div>
        <a href="/purchase-requests/create" class="rounded bg-slate-900 px-4 py-2 text-white hover:bg-slate-700">Nova solicitação</a>
    </div>

    <div class="flex flex-col gap-3 rounded-lg border border-slate-200 bg-white p-4 shadow-sm md:flex-row">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar por descrição" class="w-full rounded border border-slate-300 px-3 py-2" />
        <select wire:model.live="status" class="rounded border border-slate-300 px-3 py-2">
            <option value="">Todos os status</option>
            <option value="pending">Pendente</option>
            <option value="approved">Aprovado</option>
            <option value="rejected">Rejeitado</option>
            <option value="completed">Concluído</option>
        </select>
    </div>

    @if (session()->has('success'))
        <div class="rounded border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
    @endif

    <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50">
            <tr>
                <th class="px-4 py-3 text-left font-medium text-slate-600">Descrição</th>
                <th class="px-4 py-3 text-left font-medium text-slate-600">Status</th>
                <th class="px-4 py-3 text-left font-medium text-slate-600">Valor</th>
                <th class="px-4 py-3 text-left font-medium text-slate-600">OS</th>
                <th class="px-4 py-3 text-left font-medium text-slate-600">Ações</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
            @forelse ($purchaseRequests as $purchaseRequest)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3">{{ $purchaseRequest->description }}</td>
                    <td class="px-4 py-3 capitalize">{{ $purchaseRequest->status }}</td>
                    <td class="px-4 py-3">R$ {{ number_format($purchaseRequest->estimated_value, 2, ',', '.') }}</td>
                    <td class="px-4 py-3">{{ $purchaseRequest->serviceOrder?->code ?? 'Sem OS' }}</td>
                    <td class="px-4 py-3">
                        <div class="flex flex-wrap gap-2">
                            <a href="/purchase-requests/{{ $purchaseRequest->id }}" class="rounded bg-slate-100 px-3 py-1 text-slate-700">Visualizar</a>
                            <a href="/purchase-requests/{{ $purchaseRequest->id }}/edit" class="rounded bg-blue-100 px-3 py-1 text-blue-700">Editar</a>
                            <a href="/purchase-requests/{{ $purchaseRequest->id }}/payment-orders" class="rounded bg-emerald-100 px-3 py-1 text-emerald-700">Pagamentos</a>
                            <button wire:click="delete({{ $purchaseRequest->id }})" wire:confirm="Deseja realmente excluir esta solicitação?" class="rounded bg-red-100 px-3 py-1 text-red-700">Excluir</button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-slate-500">Nenhuma solicitação cadastrada.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $purchaseRequests->links() }}</div>
</div>
