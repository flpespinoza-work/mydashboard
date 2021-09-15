<div>
    <x-slot name="actions">
        <livewire:reports.filters :hideDates="true" :report="$reportName"/>
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
                <div class="mt-8 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <h3 class="text-sm font-semibold text-gray-600 md:text-lg">Cupones impresos</h3>
                        <div class="mt-4 overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                                            Impresos
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                                            Saldo impreso
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                                            Promedio cupón impreso
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-500 lg:text-lg whitespace-nowrap">
                                            {{ number_format($result['printed']['printed']) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 lg:text-lg whitespace-nowrap">
                                            ${{ number_format($result['printed']['amount'],2) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 lg:text-lg whitespace-nowrap">
                                            ${{ number_format($result['printed']['amount'] / $result['printed']['printed'] ,2) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="mt-8 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <h3 class="text-sm font-semibold text-gray-600 md:text-lg">Cupones canjeados</h3>
                        <div class="mt-4 overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                                            Canjeados
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                                            Saldo canjeado
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                                            Promedio cupón canjeado
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-500 lg:text-lg whitespace-nowrap">
                                            {{ number_format($result['redeems']['redeems']) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 lg:text-lg whitespace-nowrap">
                                            ${{ number_format($result['redeems']['amount'],2) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 lg:text-lg whitespace-nowrap">
                                            ${{ number_format($result['redeems']['amount'] / $result['redeems']['redeems'] ,2) }}
                                        </td>
                                    </tr>
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
