<x-app-layout>
    <x-slot name="module">Reportes</x-slot>
    <x-slot name="title">
        <div class="flex items-center">
            <div class="p-2 bg-gray-800 rounded-full">
                <x-heroicon-s-tag class="w-3 h-3 text-gray-50"/>
            </div>
            <span class="ml-2 text-gray-800">Reporte de cupones canjeados</span>
        </div>
    </x-slot>
    <x-slot name="description">Información sobre los cupones que se canjean en cada estación</x-slot>
    <livewire:reports.coupons.redeemed/>
</x-app-layout>
