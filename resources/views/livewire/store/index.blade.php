<div class="w-full mx-auto overflow-hidden">
    <div class="flex items-center p-3 space-x-3 bg-white rounded-md">
        <input class="flex-1 w-full text-sm border-gray-100 rounded-md bg-gray-50 focus:ring-gray-200 focus:border-gray-100" type="search" wire:model="search" id="search" placeholder="Buscar...">
        <button
            wire:click="create"
            class="flex items-center justify-center p-2 ml-auto transition duration-75 rounded-md bg-orange">
            <x-icons.plus class="w-5 h-5 text-orange-light"/>
            <span class="hidden ml-2 text-xs font-semibold md:inline-block text-orange-light">Nuevo establecimiento</span>
        </button>
        <a
            class="flex items-center justify-center p-2 ml-auto transition duration-75 rounded-md bg-gray-50"
            href="{{ route('groups.index') }}">
            <x-icons.group class="w-5 h-5 text-gray-500"/>
            <span class="hidden ml-2 text-xs font-semibold text-gray-500 md:inline-block">Volver a grupos</span>
        </a>
    </div>
    <div class="mt-4">
    </div>
    <div>
        <form wire:submit.prevent="saveStore">
            <x-modals.dialog wire:model.defer="showModal">
                <x-slot name="title">Crear nuevo establecimiento</x-slot>
                <x-slot name="content">
                    <div class="my-2">
                        <label class="block text-xs font-semibold text-gray-500" for="group">Grupo <span class="text-red-500">*</span></label>
                        <select wire:model.defer="group"
                        class="w-full mt-2 text-xs border-gray-100 rounded-md focus:ring-gray-200 focus:border-gray-100 bg-gray-50"
                        >
                            @foreach ($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                        @error('store.group_id')
                        <span class="font-medium text-red-400 text-xxs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="items-center md:space-x-2 md:flex">
                        <div class="my-2 md:w-2/3">
                            <label class="block text-xs font-semibold text-gray-500" for="name">Nombre del establecimiento <span class="text-red-500">*</span></label>
                            <input class="w-full mt-2 border-gray-100 rounded-md bg-gray-50 focus:ring-gray-200 focus:border-gray-100" wire:model.defer="store.name" type="text">
                            @error('store.name')
                            <span class="font-medium text-red-400 text-xxs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="my-2 md:w-1/3">
                            <label class="block text-xs font-semibold text-gray-500" for="node">Nodo Tokencash <span class="text-red-500">*</span></label>
                            <input class="w-full mt-2 border-gray-100 rounded-md bg-gray-50 focus:ring-gray-200 focus:border-gray-100" wire:model.defer="store.node" type="text">
                            @error('store.token_node')
                            <span class="font-medium text-red-400 text-xxs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="my-2 md:w-1/2">
                            <label class="block text-xs font-semibold text-gray-500" for="giftcard">Giftcard <span class="text-red-500">*</span></label>
                            <input class="w-full mt-2 border-gray-100 rounded-md bg-gray-50 focus:ring-gray-200 focus:border-gray-100" wire:model.defer="store.giftcard" type="text">
                            @error('store.token_giftcard')
                            <span class="font-medium text-red-400 text-xxs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="my-2 md:w-1/2">
                            <label class="block text-xs font-semibold text-gray-500" for="budget">Presupuesto <span class="text-red-500">*</span></label>
                            <input class="w-full mt-2 border-gray-100 rounded-md bg-gray-50 focus:ring-gray-200 focus:border-gray-100" wire:model.defer="store.budget" type="tel">
                            @error('store.token_budget')
                            <span class="font-medium text-red-400 text-xxs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="my-2">
                        <label class="block text-xs font-semibold text-gray-500" for="contact_name">Contacto</label>
                        <input class="w-full mt-2 border-gray-100 rounded-md bg-gray-50 focus:ring-gray-200 focus:border-gray-100" wire:model.defer="store.contact_name" type="text">
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="my-2 md:w-1/2">
                            <label class="block text-xs font-semibold text-gray-500" for="phone">Teléfono</label>
                            <input class="w-full mt-2 border-gray-100 rounded-md bg-gray-50 focus:ring-gray-200 focus:border-gray-100" wire:model.defer="store.phone" type="tel">
                            @error('store.phone')
                            <span class="font-medium text-red-400 text-xxs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="my-2 md:w-1/2">
                            <label class="block text-xs font-semibold text-gray-500" for="email">Correo electrónico</label>
                            <input class="w-full mt-2 border-gray-100 rounded-md bg-gray-50 focus:ring-gray-200 focus:border-gray-100" wire:model.defer="store.email" type="email">
                            @error('store.email')
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

