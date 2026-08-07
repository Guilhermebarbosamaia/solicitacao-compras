<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitações de Compras</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-50 text-slate-800">
    <div class="min-h-screen">
        <nav class="bg-white shadow-sm border-b border-slate-200">
            <div class="mx-auto max-w-7xl px-4 py-4 flex items-center justify-between">
                <a href="/" class="text-lg font-semibold">Sistema de Solicitações de Compras</a>
                <div class="flex gap-3 text-sm">
                    <a href="/" class="text-slate-600 hover:text-slate-900">Início</a>
                    <a href="/purchase-requests" class="text-slate-600 hover:text-slate-900">Solicitações</a>
                </div>
            </div>
        </nav>

        <main class="mx-auto max-w-7xl px-4 py-8">
            {{ $slot }}
        </main>
    </div>
    @livewireScripts
</body>
</html>
