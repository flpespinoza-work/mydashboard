<x-app-layout>
    <x-slot name="module">Administración</x-slot>
    <x-slot name="title">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-orange">
                <x-icons.message class="w-3 h-3 text-gray-50"/>
            </div>
            <span class="ml-2 text-gray-800">Permisos de Usuario</span>
        </div>
    </x-slot>
    <x-slot name="description"></x-slot>
    <livewire:permission.index/>
</x-app-layout>
