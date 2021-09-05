<div
class="space-y-6 lg:flex lg:space-y-0 lg:space-x-6">
    <div id="response-form" class="overflow-hidden bg-white border border-gray-100 rounded-md shadow-sm lg:w-1/3 lg:max-h-48">
        <form wire:submit.prevent="addResponse">
            <div class="p-3">
                <label for="response" class="block text-sm font-medium text-gray-700">
                Ingresa el texto de la respuesta
                </label>
                <div class="mt-3">
                    <textarea id="response"
                    wire:model.defer="response"
                    rows="3"
                    class="block w-full mt-1 border border-gray-100 rounded-md resize-none bg-gray-50 focus:ring-0 focus:border-gray-200 sm:text-sm"
                    placeholder="Respuesta"></textarea>
                </div>
            </div>
            <div class="flex items-center justify-end p-3">
                <button wire:click="resetForm" class="w-1/2 py-2 text-xs font-semibold text-gray-500 rounded-md md:w-40">Cancelar</button>
                <button class="w-1/2 py-2 text-xs font-semibold bg-blue-600 rounded-md md:w-40 text-blue-50">Guardar</button>
            </div>
        </form>
    </div>

    <div id="response-list" class="p-3 space-y-2 bg-white border rounded-md shadow-sm border-gray-50 lg:flex-1">
        <div class="my-5">
            <input type="search"
            placeholder="Buscar"
            wire:model="search"
            id="search"
            class="w-full text-sm border-gray-100 rounded-sm bg-gray-25 focus:border-gray-100 focus:ring-gray-300">
        </div>
        @forelse ($responses as $response)
            <div class="flex items-center p-3 border rounded-md border-gray-50 bg-gray-50">
                <p class="font-light text-gray-500">{{ $response->response}}</p>
                <span wire:click="deleteResponse({{$response}})" class="ml-auto cursor-pointer">
                    <x-icons.trash class="w-4 h-4 ml-auto" />
                </span>
            </div>
        @empty
            <p class="font-medium text-center">No hay respuestas registradas</p>
        @endforelse

        {{ $responses->links() }}
    </div>
</div>
