<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-semibold">Dashboard</h1>
            <p class="text-slate-600">Visão geral do fluxo de solicitações de compra.</p>
        </div>
        <a href="/purchase-requests/create" class="rounded bg-slate-900 px-4 py-2 text-white hover:bg-slate-700">Nova solicitação</a>
    </div>

    <div class="grid gap-4 md:grid-cols-4">
        <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-sm text-slate-500">Solicitações</p>
            <p class="text-2xl font-semibold">{{ $purchaseRequestsCount }}</p>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-sm text-slate-500">Ordens de serviço</p>
            <p class="text-2xl font-semibold">{{ $serviceOrdersCount }}</p>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-sm text-slate-500">Ordens de pagamento</p>
            <p class="text-2xl font-semibold">{{ $paymentOrdersCount }}</p>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-sm text-slate-500">Pendentes</p>
            <p class="text-2xl font-semibold">{{ $pendingPurchases }}</p>
        </div>
    </div>

    <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-xl font-semibold">Resumo do processo</h2>
        <ul class="mt-4 list-disc space-y-2 pl-6 text-slate-600">
            <li>Uma solicitação pode ou não estar vinculada a uma ordem de serviço.</li>
            <li>Uma solicitação pode ter várias ordens de pagamento.</li>
            <li>Pagamentos à vista não precisam de parcelas.</li>
            <li>Pagamentos parcelados exigem parcelas com somatório igual ao valor total.</li>
        </ul>
    </div>
</div>
