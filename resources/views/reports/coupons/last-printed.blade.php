<x-app-layout>
    <x-slot name="module">Reportes</x-slot>
    <x-slot name="title">
        <div class="flex items-center">
            <div class="p-2 bg-gray-800 rounded-full">
                <x-heroicon-s-tag class="w-3 h-3 text-gray-50"/>
            </div>
            <span class="ml-2 text-gray-800">Reporte de último cupon impreso</span>
        </div>
    </x-slot>
    <x-slot name="description">Cuando se imprimió el último cupon de cada establecimiento</x-slot>
    <livewire:reports.coupons.last-printed/>
</x-app-layout>
