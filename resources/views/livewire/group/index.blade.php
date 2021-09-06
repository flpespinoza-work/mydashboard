<div class="w-full mx-auto overflow-hidden">
    <div class="flex items-center p-3 space-x-3 bg-white rounded-md">
        <input class="flex-1 w-full text-sm border-gray-100 rounded-md bg-gray-50 focus:ring-gray-200 focus:border-gray-100" type="search" wire:model="search" id="search" placeholder="Buscar...">
        <button
            wire:click="create"
            class="flex items-center justify-center p-2 ml-auto transition duration-75 rounded-md bg-orange">
            <x-icons.plus class="w-5 h-5 text-green-50"/>
            <span class="hidden ml-2 text-xs font-semibold md:inline-block text-orange-light">Nuevo grupo</span>
        </button>
    </div>
    <div class="mt-4">
    </div>
    <div>
        <form wire:submit.prevent="saveResponse">
            <x-modals.dialog wire:model.defer="showModal">
                <x-slot name="title">Crear nuevo grupo</x-slot>
                <x-slot name="content">
                    <textarea
                        wire:model.defer="group.name"
                        class="w-full p-2 border-gray-100 rounded-md resize-none bg-gray-50 focus:ring-gray-200 focus:border-gray-100"
                        placeholder="Ingrese el texto de la respuesta"
                        id="response"
                        rows="3">
                    </textarea>
                </x-slot>
                <x-slot name="footer">
                    <button type="button" x-on:click="show=false" class="px-4 py-2 font-semibold text-gray-500 bg-gray-200 rounded-md">Cancelar</button>
                    <button type="submit" class="px-4 py-2 font-semibold rounded-md text-orange-light bg-orange">Guardar</button>
                </x-slot>
            </x-modals.dialog>
        </form>
    </div>
</div>
