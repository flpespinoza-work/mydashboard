<x-app-layout>
    <x-slot name="title">
        <div class="flex items-center">
            <div class="p-1 bg-gray-800 rounded-full">
                <x-heroicon-s-chart-square-bar class="w-4 h-4 text-gray-50"/>
            </div>
            <span class="ml-2 text-gray-800">Dashboard</span>
        </div>
    </x-slot>
    <livewire:dashboard.index />
</x-app-layout>
