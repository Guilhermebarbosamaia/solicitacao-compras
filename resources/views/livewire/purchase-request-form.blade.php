<div class="max-w-3xl space-y-6">
    <div>
        <h1 class="text-3xl font-semibold">{{ $isEditing ? 'Editar solicitação' : 'Nova solicitação' }}</h1>
        <p class="text-slate-600">Cadastre uma solicitação e vincule ou não uma ordem de serviço.</p>
    </div>

    <form wire:submit="save" class="space-y-4 rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        @if (session()->has('success'))
            <div class="rounded border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
        @endif

        <div class="grid gap-4 md:grid-cols-2">
            <div class="md:col-span-2">
                <label class="mb-1 block text-sm font-medium">Descrição</label>
                <input type="text" wire:model="description" class="w-full rounded border border-slate-300 px-3 py-2" />
                @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
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

            <div>
                <label class="mb-1 block text-sm font-medium">Valor estimado</label>
                <input type="number" step="0.01" wire:model="estimated_value" class="w-full rounded border border-slate-300 px-3 py-2" />
                @error('estimated_value') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="mb-1 block text-sm font-medium">Ordem de serviço</label>
                <select wire:model="service_order_id" class="w-full rounded border border-slate-300 px-3 py-2">
                    <option value="">Sem ordem de serviço</option>
                    @foreach($serviceOrders as $id => $code)
                        <option value="{{ $id }}">{{ $code }}</option>
                    @endforeach
                </select>
                @error('service_order_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="rounded bg-slate-900 px-4 py-2 text-white hover:bg-slate-700">Salvar</button>
            <a href="/purchase-requests" class="rounded border border-slate-300 px-4 py-2 text-slate-700">Cancelar</a>
        </div>
    </form>
</div>
