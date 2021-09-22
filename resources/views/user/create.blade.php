<x-app-layout>
    <x-slot name="sectionTitle">Administración</x-slot>
    <x-slot name="title">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-orange">
                <x-icons.message class="w-3 h-3 text-gray-50"/>
            </div>
            <span class="ml-2 text-gray-800">Administración de usuarios - Crear usuario</span>
        </div>
    </x-slot>
    <x-slot name="description">Alta de nuevo usuario</x-slot>
    <livewire:user.create/>
</x-app-layout>
