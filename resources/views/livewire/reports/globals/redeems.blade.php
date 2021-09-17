<div>

    <x-slot name="actions">
        <livewire:reports.globals.filters :report="$reportName"/>
    </x-slot>

    <div class="min-h-full mt-14">
        <div wire:loading.delay class="w-full">
            <p class="text-xs font-semibold text-center md:text-sm">
                <x-loader class="w-10 h-10" />
                Obteniendo información...
            </p>
        </div>

        @if (!is_null($result) && !empty($result))
        <div wire:loading.remove>
            <h3 class="text-sm font-semibold text-gray-600 md:text-lg lg:text-xl">Establecimiento: {{ $store_name }}</h3>
            <div class="w-full mt-8 h-60 md:h-96 bg-gray-50">

            </div>
            <div class="mt-8 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                                        Establecimiento
                                    </th>
                                    @foreach ($result['days'] as $day)
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                                        {{ $day }}
                                    </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($result['redeems'] as $store => $days)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $store }}
                                        </td>
                                        @foreach ($days as $redeems)
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $redeems }}
                                        </td>
                                        @endforeach
                                    </tr>
                                @empty
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        No existen registros para esta búsqueda
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @else
            <div wire:loading.remove>
                @if (!is_null($result) && empty($result))
                    <p class="text-xs font-semibold text-center md:text-sm">No hay resultados para la busqueda</p>
                @else
                   <p class="text-xs font-semibold text-center md:text-sm">No hay información que mostrar</p>
                @endif
            </div>
        @endif
    </div>
</div>

