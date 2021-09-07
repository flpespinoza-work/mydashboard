<x-app-layout>
    <x-slot name="module">Administración</x-slot>
    <x-slot name="title">
        <div class="flex items-center">
            <div class="p-2 bg-gray-800 rounded-full">
                <x-icons.group class="w-3 h-3 text-gray-50"/>
            </div>
            <span class="ml-2 text-gray-800">Grupos</span>
        </div>
    </x-slot>
    <x-slot name="description">Administración de los grupos del sistema</x-slot>
    <livewire:group.index/>
</x-app-layout>
