<div class="w-full mx-auto overflow-hidden">
    <div class="flex items-center py-3 bg-white rounded-md">
        <input
            class="w-10/12 text-sm border-gray-100 rounded-md md:w-1/3 bg-gray-50 focus:ring-gray-200 focus:border-gray-100"
            type="search"
            wire:model="search"
            id="search"
            placeholder="Buscar...">
        @can('can_create_new_response')
        <button
            wire:click="create"
            class="flex items-center justify-center p-2 ml-3 transition duration-75 rounded-md md:ml-8 bg-orange">
            <x-icons.plus class="w-5 h-5 text-green-50"/>
            <span class="hidden ml-2 text-xs font-semibold md:inline-block text-orange-light">Nueva respuesta</span>
        </button>
        @endcan
    </div>
    <div class="mt-4">
        @foreach ($responses as $response)
            <div class="p-2 my-2 rounded-md md:w-3/5 bg-gray-50">
                <small>Creado el {{ $response->created_at }}</small>
                <p class="text-sm font-semibold text-gray-500" wire:click="edit({{$response}})">{{ $response->response }}</p>
            </div>
        @endforeach
    </div>
    <div>
        <form wire:submit.prevent="saveResponse">
            <x-modals.dialog maxWidth="sm" wire:model.defer="showModal">
                <x-slot name="title">Crear respuesta</x-slot>
                <x-slot name="content">
                    <textarea
                        wire:model.defer="response.response"
                        class="w-full p-2 text-sm border-gray-100 rounded-md resize-none bg-gray-50 focus:ring-gray-200 focus:border-gray-100"
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
