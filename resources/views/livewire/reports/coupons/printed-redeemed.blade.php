<div>
    <x-slot name="actions">
        <livewire:reports.filters :report="$reportName"/>
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
                <div class="grid grid-cols-2 gap-4 mt-8 md:grid-cols-4">
                    <div class="col-span-1 p-4 bg-white border border-gray-100 rounded-md shadow-sm">
                        <h5 class="text-xs font-semibold text-gray-400 md:text-sm"><span class="text-gray-700">{{ number_format($result['totals']['printed']) }}</span> Cupones impresos</h5>
                        <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">${{ number_format($result['totals']['printed_amount']) }} </span>
                    </div>
                    <div class="col-span-1 p-4 bg-white border border-gray-100 rounded-md shadow-sm">
                        <h5 class="text-xs font-semibold text-gray-400 md:text-sm">Promedio por cupón impreso:</h5>
                        <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">${{ number_format($result['totals']['avg_printed'],2) }} </span>
                    </div>
                    <div class="col-span-1 p-4 bg-white border border-gray-100 rounded-md shadow-sm">
                        <h5 class="text-xs font-semibold text-gray-400 md:text-sm"><span class="text-gray-700">{{ number_format($result['totals']['redeemed']) }}</span> Cupones canjeados</h5>
                        <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">${{ number_format($result['totals']['redeemed_amount']) }} </span>
                    </div>
                    <div class="col-span-1 p-4 bg-white border border-gray-100 rounded-md shadow-sm">
                        <h5 class="text-xs font-semibold text-gray-400 md:text-sm">Promedio por cupón canjeado:</h5>
                        <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">${{ number_format($result['totals']['avg_redeemed'], 2) }} </span>
                    </div>
                    <div class="col-span-1 p-4 bg-white border border-gray-100 rounded-md shadow-sm">
                        <h5 class="text-xs font-semibold text-gray-400 md:text-sm">Porcentaje impresión-canje:</h5>
                        <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">{{ number_format(($result['totals']['redeemed'] * 100) / $result['totals']['printed'], 2) }}% </span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-8">
                    <div class="h-64 col-span-2 p-4 border rounded-md shadow-sm bg-gray-25 border-gray-50 md:h-80 lg:h-96">
                        <livewire:livewire-line-chart :line-chart-model="$couponsChartModel" :wire:key="time()"/>
                    </div>
                </div>

                <div class="mt-8 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <h5 class="text-sm font-medium text-gray-500 md:text-base">Detallado de cupones impresos vs canjeados</h5>
                        <div class="mt-4 overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize md:text-sm">
                                            Fecha
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize md:text-sm">
                                            Cupones impresos
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize md:text-sm">
                                            Cupones canjeados
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize md:text-sm">
                                            %
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($result['coupons'] as $day => $data)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $day }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $data['printed'] }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $data['redeemed'] }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ number_format($data['redeemed'] * 100 / $data['printed'], 2) }}%
                                        </td>
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

                <div class="mt-8 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <h5 class="text-sm font-medium text-gray-500 md:text-base">Detallado de dinero impreso vs canjeado</h5>
                        <div class="mt-4 overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize md:text-sm">
                                            Fecha
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize md:text-sm">
                                            Dinero impreso
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize md:text-sm">
                                            Dinero canjeado
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize md:text-sm">
                                            %
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($result['coupons'] as $day => $data)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $day }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ number_format($data['printed_amount'],2) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ number_format($data['redeemed_amount'],2) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ number_format($data['redeemed_amount'] * 100 / $data['printed_amount'], 2) }}%
                                        </td>
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
