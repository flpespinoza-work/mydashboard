<div class="w-full mx-auto overflow-hidden">
    <div class="flex items-center py-3 bg-white rounded-md">
        <input class="flex-1 w-full max-w-lg text-sm border-gray-100 rounded bg-gray-50 focus:ring-gray-200 focus:border-gray-100" type="search" wire:model.debounce.500ms="search" id="search" placeholder="Buscar...">
        <button
            class="flex items-center justify-center p-2 ml-auto transition duration-75 rounded-md bg-orange">
            <x-icons.plus class="w-5 h-5 text-orange-light"/>
            <span class="hidden ml-2 text-xs font-semibold md:inline-block text-orange-light">Nueva campaña</span>
        </button>
    </div>
    <div class="mt-4">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-md">
                        <table class="min-w-full divide-y divide-gray-200 table-auto">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                                        Campaña
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                                        Tipo
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                                        Estatus
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                                        Creación
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                                        Autor
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if ($campaigns->count() > 0)
                                    @foreach ($campaigns as $campaign)
                                        <tr>
                                            <td>{{ $campaign->CAMP_NOMBRE }}</td>
                                            <td>{{ $campaign->notification->NOT_TIPO }}</td>
                                            <td>{{ $campaign->CAMP_AUTORIZACION }}</td>
                                            <td>{{ $campaign->CAMP_TS }}</td>
                                            <td>{{ $campaign->CAMP_AUTOR }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <p>No hay campañas registradas</p>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

