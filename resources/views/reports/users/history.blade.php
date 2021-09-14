<x-app-layout>
    <x-slot name="module">Reportes</x-slot>
    <x-slot name="title">
        <div class="flex items-center">
            <div class="p-2 bg-gray-800 rounded-full">
                <x-heroicon-s-user class="w-3 h-3 text-gray-50"/>
            </div>
            <span class="ml-2 text-gray-800">Reporte acumulado de usuarios</span>
        </div>
    </x-slot>
    <x-slot name="description">Acumulado de usuarios por establecimiento</x-slot>
    <livewire:reports.users.history/>
</x-app-layout>
