<x-app-layout>
    <x-slot name="module">Reportes</x-slot>
    <x-slot name="title">
        <div class="flex items-center">
            <div class="p-1 bg-gray-800 rounded-full">
                <x-heroicon-s-globe class="w-5 h-5 text-gray-50"/>
            </div>
            <span class="ml-2 text-gray-800">Reporte global de altas diarias</span>
        </div>
    </x-slot>
    <x-slot name="description"></x-slot>
    <livewire:reports.globals.registers/>
</x-app-layout>
