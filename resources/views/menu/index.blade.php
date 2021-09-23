<x-app-layout>
    <x-slot name="sectionTitle">Administración</x-slot>
    <x-slot name="title">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-orange">
                <x-icons.message class="w-3 h-3 text-gray-50"/>
            </div>
            <span class="ml-2 text-gray-800">Administración de menus</span>
        </div>
    </x-slot>
    <livewire:menu.index/>
</x-app-layout>
