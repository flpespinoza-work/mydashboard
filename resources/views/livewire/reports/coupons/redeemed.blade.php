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
                <h3 class="text-sm font-semibold text-gray-600 md:text-lg lg:text-xl">Establecimiento: {{ $store_name }}</h3>
                <div class="grid grid-cols-2 gap-4 mt-8 md:grid-cols-4">
                    <div class="col-span-1 p-4 border border-gray-100 rounded-sm bg-gray-50">
                        <h5 class="text-xs font-semibold text-gray-400 md:text-sm">Cupones canjeados</h5>
                        <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">{{ number_format($result['totals']['redeemed_coupons']) }} </span>
                    </div>
                    <div class="col-span-1 p-4 border border-gray-100 rounded-sm bg-gray-50">
                        <h5 class="text-xs font-semibold text-gray-400 md:text-sm">Dinero canjeado:</h5>
                        <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">${{ number_format($result['totals']['redeemed_amount']) }} </span>
                    </div>
                    <div class="col-span-1 p-4 border border-gray-100 rounded-sm bg-gray-50">
                        <h5 class="text-xs font-semibold text-gray-400 md:text-sm">Promedio de canje:</h5>
                        <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">${{ number_format($result['totals']['average_amount'], 2) }} </span>
                    </div>
                    <div class="col-span-1 p-4 border border-gray-100 rounded-sm bg-gray-50">
                        <h5 class="text-xs font-semibold text-gray-400 md:text-sm">Ticket de carga promedio:</h5>
                        <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">${{ number_format($result['totals']['average_amount'] / 0.029, 2) }} </span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-8">
                    <div class="h-64 col-span-2 p-4 border rounded-md shadow-sm bg-gray-25 border-gray-50 md:col-span-1 md:h-80 lg:h-96">
                        <livewire:livewire-area-chart :area-chart-model="$couponsChartModel" :wire:key="time()"/>
                    </div>
                    <div class="h-64 col-span-2 p-4 border rounded-md shadow-sm bg-gray-25 border-gray-50 md:col-span-1 md:h-80 lg:h-96">
                        <livewire:livewire-area-chart :area-chart-model="$amountChartModel" :wire:key="time()"/>
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
                                            Cupones canjeados
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                                            Monto canje
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                                            Promedio canje
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($result['coupons'] as $data)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $data['day'] }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ number_format($data['count']) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            ${{ number_format($data['amount'], 2) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            ${{ number_format($data['average'], 2) }}
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
                                            <span class="font-semibold text-gray-darker">Canjeas totales: {{ number_format($result['totals']['redeemed_coupons']) }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            <span class="font-semibold text-gray-darker">Monto total: ${{ number_format($result['totals']['redeemed_amount']) }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            <span class="font-semibold text-gray-darker">Promedio canje: ${{ number_format($result['totals']['average_amount'], 2) }}</span>
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
