<x-app-layout>
    <x-slot name="module">Reportes</x-slot>
    <x-slot name="title">
        <div class="flex items-center">
            <div class="p-2 bg-gray-800 rounded-full">
                <x-heroicon-s-credit-card class="w-3 h-3 text-gray-50"/>
            </div>
            <span class="ml-2 text-gray-800">Reporte saldo disponible</span>
        </div>
    </x-slot>
    <x-slot name="description">Muestra el saldo disponible para cada establecimiento</x-slot>
    <livewire:reports.balance.balance/>
</x-app-layout>
