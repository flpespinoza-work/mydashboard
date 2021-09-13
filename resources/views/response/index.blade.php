<x-app-layout>
    <x-slot name="module">Administración</x-slot>
    <x-slot name="title">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-orange">
                <x-icons.message class="w-3 h-3 text-gray-50"/>
            </div>
            <span class="ml-2 text-gray-800">Respuestas predefinidas</span>
        </div>
    </x-slot>
    <x-slot name="description">Administra las respuestas que serán enviadas al usuario en el módulo de calificaciones</x-slot>
    <livewire:response.index/>
</x-app-layout>
