<div>

    <x-slot name="actions">
        <livewire:reports.filters :report="$reportName"/>
    </x-slot>

    <div class="min-h-full mt-4 lg:mt-8">
        <div wire:loading.delay class="w-full">
            <p class="text-xs font-semibold text-center md:text-sm">
                <x-loader class="w-10 h-10" />
                Obteniendo información...
            </p>
        </div>

        @if (!is_null($result) && !empty($result))
        <div wire:loading.remove>
            <div class="flex items-center">
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 md:text-lg lg:text-xl">Establecimiento: {{ $report_data['store'] }}</h3>
                    <h5 class="text-xs font-medium text-gray-500 md:text-base">{{ $report_data['period'] }}</h5>
                </div>

                <button
                wire:click.prefetch="exportReport"
                type="button"
                class="px-4 py-2 ml-auto text-sm font-semibold bg-gray-800 rounded-md hover:bg-gray-700 text-gray-50">
                    <x-heroicon-s-document-download class="w-4 h-4 md:h-5 md:w-5" />
                 </button>
            </div>
            <div class="grid grid-cols-3 gap-4 mt-8 md:grid-cols-4">
                <div class="col-span-1 p-4 border border-gray-100 rounded-sm bg-gray-50">
                    <h5 class="text-xs font-semibold text-gray-400 sm:text-sm">Ventas totales</h5>
                    <span class="inline-block mt-2 text-sm font-semibold sm:text-lg text-gray-darker md:text-xl xl:text-3xl">{{ number_format($result['totals']['sales']) }} </span>
                </div>
                <div class="col-span-1 p-4 border border-gray-100 rounded-sm bg-gray-50">
                    <h5 class="text-xs font-semibold text-gray-400 md:text-sm">Monto total:</h5>
                    <span class="inline-block mt-2 text-sm font-semibold sm:text-lg text-gray-darker md:text-xl xl:text-3xl">${{ number_format($result['totals']['amount']) }} </span>
                </div>
                <div class="col-span-1 p-4 border border-gray-100 rounded-sm bg-gray-50">
                    <h5 class="text-xs font-semibold text-gray-400 md:text-sm">Venta promedio</h5>
                    <span class="inline-block mt-2 text-sm font-semibold sm:text-lg text-gray-darker md:text-xl xl:text-3xl">${{ number_format($result['totals']['amount'] /$result['totals']['sales'], 2) }} </span>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-8">
                <div class="h-64 col-span-2 p-4 border rounded-md shadow-sm bg-gray-25 border-gray-50 md:h-96">
                    <livewire:livewire-area-chart :area-chart-model="$salesChartModel" :wire:key="time()"/>
                </div>
            </div>

            <div class="mt-8 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                                        Fecha
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                                        Ventas
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                                        Monto de ventas
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                                        Venta promedio
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($result['sales'] as $day => $data)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $data['date'] }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ number_format($data['sales']) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        ${{ number_format($data['amount'], 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        ${{ number_format($data['amount'] / $data['sales'], 2) }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        No existen registros para esta búsqueda
                                    </td>
                                </tr>
                                @endforelse

                                @if ($result['totals'])
                                <tr>
                                    <td>&nbsp;</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        <span class="font-semibold text-gray-darker">Ventas totales: {{ number_format($result['totals']['sales']) }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        <span class="font-semibold text-gray-darker">Monto total de venta: ${{ number_format($result['totals']['amount']) }}</span>
                                    </td>
                                </tr>
                                @endif
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

