<x-app-layout>
    <x-slot name="sectionTitle">Administración</x-slot>
    <x-slot name="title">
        <div class="flex items-center">
            <div class="p-2 bg-gray-800 rounded-full">
                <x-icons.group class="w-3 h-3 text-gray-50"/>
            </div>
            <span class="ml-2 text-gray-800">Establecimientos</span>
        </div>
    </x-slot>
    <x-slot name="description">Administración de los establecimientos para asignar a los usuarios</x-slot>
    <livewire:store.index/>
</x-app-layout>
