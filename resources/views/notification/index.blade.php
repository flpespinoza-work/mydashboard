<x-app-layout>
    <x-slot name="title">
        <div class="flex items-center">
            <div class="p-1 bg-gray-800 rounded-full">
                <x-heroicon-s-bell class="w-4 h-4 text-gray-50" />
            </div>
            <span class="ml-2 text-gray-800">Campañas y notificaciones</span>
        </div>
    </x-slot>
    <livewire:notification.index />
</x-app-layout>
