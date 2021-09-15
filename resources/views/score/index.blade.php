<x-app-layout>
    <x-slot name="title">
        <div class="flex items-center">
            <div class="p-1 bg-gray-800 rounded-full">
                <x-heroicon-s-star class="w-4 h-4 text-gray-50" />
            </div>
            <span class="ml-2 text-gray-800">Calificaciones</span>
        </div>
    </x-slot>
    <livewire:score.index :key="time()"/>
</x-app-layout>
