<div class="lg:flex">
    <div id="response-form" class="p-4 bg-white lg:w-96 h-64 max-h-64">
            <div class="flex flex-col space-y-2 text-xs">
                <label for="response" class="font-semibold text-gray-600">Agregar nueva respuesta</label>
                <textarea wire:model.defer="response" id="response" class="border-none bg-gray-50 rounded-sm focus:ring-gray-200 h-32"></textarea>
            </div>
            <div class="mt-6 lg:flex lg:justify-between lg:space-x-3">
                <button wire:click="resetForm" class="py-3 w-full lg:w-1/2 text-center font-bold inline-block rounded border-2 border-gray-600">Cancelar</button>
                <button type="submit" class=" mt-3 lg:mt-0 py-3 w-full lg:w-1/2 text-center font-bold inline-block text-blue-50 bg-blue-700 rounded">Guardar</button>
            </div>
        </form>
    </div>
    <div id="response-list" class="md:flex-1 lg:ml-6 bg-red-50 mt-6 lg:mt-0 lg:min-h-screen">
        @forelse ($responses as $response)
            <p>{{ $response->response }}</p>
        @empty
            <p>No hay respuestas registradas</p>
        @endforelse
    </div>
</div>
