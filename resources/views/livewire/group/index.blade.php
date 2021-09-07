<div class="w-full mx-auto overflow-hidden">
    <div class="flex items-center p-3 space-x-3 bg-white rounded-md">
        <input class="flex-1 w-full text-sm border-gray-100 rounded-md bg-gray-50 focus:ring-gray-200 focus:border-gray-100" type="search" wire:model="search" id="search" placeholder="Buscar...">
        <button
            wire:click="create"
            class="flex items-center justify-center p-2 ml-auto transition duration-75 rounded-md bg-orange">
            <x-icons.plus class="w-5 h-5 text-orange-light"/>
            <span class="hidden ml-2 text-xs font-semibold md:inline-block text-orange-light">Nuevo grupo</span>
        </button>
        <a
            class="flex items-center justify-center p-2 ml-auto transition duration-75 rounded-md bg-gray-50"
            href="{{ route('stores.index') }}">
            <x-icons.group class="w-5 h-5 text-gray-500"/>
            <span class="hidden ml-2 text-xs font-semibold text-gray-500 md:inline-block">Ver establecimientos</span>
        </a>
    </div>
    <div class="mt-4">
        @forelse ($groups as $group)
            <p wire:click="edit({{$group}})">{{ $group->name }}</p>
        @empty
            <p>No hay grupos para mostrar</p>
        @endforelse
    </div>
    <div>
        <form wire:submit.prevent="saveGroup">
            <x-modals.dialog maxWidth="sm" wire:model.defer="showModal">
                <x-slot name="title">Crear nuevo grupo</x-slot>
                <x-slot name="content">
                    <div class="my-2">
                        <label class="block text-xs font-semibold text-gray-500" for="name">Nombre del grupo <span class="text-red-500">*</span></label>
                        <input class="w-full mt-2 border-gray-100 rounded-md bg-gray-50 focus:ring-gray-200 focus:border-gray-100" wire:model.defer="group.name" type="text">
                        @error('group.name')
                        <span class="font-medium text-red-400 text-xxs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label class="block text-xs font-semibold text-gray-500" for="contact">Nombre de contacto</label>
                        <input class="w-full mt-2 border-gray-100 rounded-md bg-gray-50 focus:ring-gray-200 focus:border-gray-100" wire:model.defer="group.contact" type="text">
                        @error('group.contact')
                        <span class="font-medium text-red-400 text-xxs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="items-center space-x-2 md:flex">
                        <div class="my-2 md:w-1/2">
                            <label class="block text-xs font-semibold text-gray-500" for="email">Correo electrónico</label>
                            <input class="w-full mt-2 border-gray-100 rounded-md bg-gray-50 focus:ring-gray-200 focus:border-gray-100" wire:model.defer="group.email" type="email">
                            @error('group.email')
                            <span class="font-medium text-red-400 text-xxs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="my-2 md:w-1/2">
                            <label class="block text-xs font-semibold text-gray-500" for="phone">Teléfono</label>
                            <input class="w-full mt-2 border-gray-100 rounded-md bg-gray-50 focus:ring-gray-200 focus:border-gray-100" wire:model.defer="group.phone" type="tel">
                            @error('group.phone')
                            <span class="font-medium text-red-400 text-xxs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </x-slot>
                <x-slot name="footer">
                    <button type="button" x-on:click="show=false" class="px-4 py-2 font-semibold text-gray-500 bg-gray-200 rounded-md">Cancelar</button>
                    <button type="submit" class="px-4 py-2 font-semibold rounded-md text-orange-light bg-orange">Guardar</button>
                </x-slot>
            </x-modals.dialog>
        </form>
    </div>
</div>
