<div>
    <x-slot name="actions">
        <livewire:reports.filters-activity :report="$reportName"/>
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
            <div class="flex items-center">
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 md:text-lg lg:text-xl">Establecimiento: {{ $report_data['store'] }}</h3>
                    <h5 class="text-xs font-medium text-gray-500 md:text-base">{{ $report_data['period'] }}</h5>
                </div>
            </div>
            <div class="mt-8">
                <div class="grid grid-cols-3 gap-2">
                    <div class="col-span-3 p-3 rounded md:col-span-1 bg-gray-50">
                        <p class="font-semibold uppercase">Información del usuario</p>
                        <p class="flex flex-col mt-2 space-y-1 text-xs text-gray-600 md:text-base">
                            <span class="block font-medium">NUN ID: <span class="font-normal text-gray-500">{{ $result['info']->NODO}}</span></span>
                            <span class="block font-medium">Nombre: <span class="font-normal text-gray-500">{{ $result['info']->NOMBRE}}</span></span>
                            <span class="block font-medium">Teléfono: <span class="font-normal text-gray-500">{{ substr_replace($result['info']->NUMERO, '****', -4) }}</span></span>
                            <span class="block font-medium">Correo: <span class="font-normal text-gray-500">{{ $result['info']->CORREO}}</span></span>
                            <span class="block font-medium">Usuario desde: <span class="font-normal text-gray-500">{{ $result['info']->FECHA_ALTA}}</span></span>
                            <span class="block font-medium">Estado: <span class="font-normal text-gray-500">Activo</span></span>
                        </p>
                    </div>
                    <div class="grid grid-cols-2 col-span-3 grid-rows-2 gap-2 md:grid-cols-3 md:col-span-2">
                        <div class="col-span-1 p-3 rounded-md drop-shadow-sm bg-gray-50 sm:col-span-1 md:col-span-1 ">
                            <h5 class="text-xs font-light text-gray-500 lg:text-sm">Saldo</h5>
                            <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">${{ number_format($result['info']->SALDO,2) }}</p>
                        </div>
                        <div class="col-span-1 p-3 rounded-md drop-shadow-sm bg-gray-50 sm:col-span-1 md:col-span-1 ">
                            <h5 class="text-xs font-light text-gray-500 lg:text-sm">Canjes del periodo: {{ number_format($result['redeems_period']['redeems']) }}</h5>
                            <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">${{ number_format($result['redeems_period']['amount'],2) }}</p>
                        </div>
                        <div class="col-span-1 p-3 rounded-md drop-shadow-sm bg-gray-50 sm:col-span-1 md:col-span-1 ">
                            <h5 class="text-xs font-light text-gray-500 lg:text-sm">Canjes totales: {{ number_format($result['redeems_total']->CANJES) }}</h5>
                            <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">${{ number_format($result['redeems_total']->MONTO,2) }}</p>
                        </div>
                        <div class="col-span-1 p-3 rounded-md drop-shadow-sm bg-gray-50 sm:col-span-1 md:col-span-1 ">
                            <h5 class="text-xs font-light text-gray-500 lg:text-sm">Compras del periodo: {{ number_format($result['sales_period']['sales']) }}</h5>
                            <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">${{ number_format($result['sales_period']['amount'],2) }}</p>
                        </div>
                        <div class="col-span-1 p-3 rounded-md drop-shadow-sm bg-gray-50 sm:col-span-1 md:col-span-1 ">
                            <h5 class="text-xs font-light text-gray-500 lg:text-sm">Compras totales: {{ number_format($result['sales_total']->VENTAS) }}</h5>
                            <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">${{ number_format($result['sales_total']->MONTO,2) }}</p>
                        </div>
                    </div>
                </div>

                <div class="w-full py-3 mt-8 text-xs rounded-md h-60 md:h-96 bg-gray-50">
                    <livewire:livewire-line-chart
                    key="{{ $chartModel->reactiveKey() }}"
                    :line-chart-model="$chartModel"
                    />
                </div>

                <div class="mt-8 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <h3 class="py-3 font-semibold text-center">Detallado de cupones canjeados</h3>
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                                            #
                                        </th>
                                        <th scope="col" class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                                            Cupón ID
                                        </th>
                                        <th scope="col" class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                                            Fecha de impresión
                                        </th>
                                        <th scope="col" class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                                            Fecha de canje
                                        </th>
                                        <th scope="col" class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                                            Código de cupón
                                        </th>
                                        <th scope="col" class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                                            Monto
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($result['redeems'] as $redeem)
                                    <tr>
                                        <td class="px-4 py-3 text-xs text-gray-500 whitespace-nowrap">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-4 py-3 text-xs text-gray-500 whitespace-nowrap">
                                            {{ $redeem->ID }}
                                        </td>
                                        <td class="px-4 py-3 text-xs text-gray-500 whitespace-nowrap">
                                            {{ $redeem->IMPRESION }}
                                        </td>
                                        <td class="px-4 py-3 text-xs text-gray-500 whitespace-nowrap">
                                            {{ $redeem->CANJE }}
                                        </td>
                                        <td class="px-4 py-3 text-xs text-gray-500 whitespace-nowrap">
                                            <span class="px-2 py-1 text-green-700 bg-green-100 rounded-full">{{ $redeem->CODIGO }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-xs text-gray-500 whitespace-nowrap">
                                            ${{ number_format($redeem->MONTO,2) }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">
                                            No existen registros de canjes
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="mt-8 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <h3 class="py-3 font-semibold text-center">Detallado de ventas</h3>
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                                            #
                                        </th>
                                        <th scope="col" class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                                            Venta ID
                                        </th>
                                        <th scope="col" class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                                            Fecha de venta
                                        </th>
                                        <th scope="col" class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                                            Monto
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($result['sales'] as $sale)
                                    <tr>
                                        <td class="px-4 py-3 text-xs text-gray-500 whitespace-nowrap">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-4 py-3 text-xs text-gray-500 whitespace-nowrap">
                                            {{ $sale->ID }}
                                        </td>
                                        <td class="px-4 py-3 text-xs text-gray-500 whitespace-nowrap">
                                            {{ $sale->FECHA }}
                                        </td>
                                        <td class="px-4 py-3 text-xs text-gray-500 whitespace-nowrap">
                                            ${{ number_format($sale->MONTO,2) }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">
                                            No existen registros de ventas
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
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
