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
                    <div class="col-span-1 p-4 bg-white border border-gray-100 rounded-md shadow-sm">
                        <h5 class="text-sm font-semibold text-gray-400">Cupones canjeados</h5>
                        <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">{{ number_format($result['totals']['redeemed_coupons']) }} </span>
                    </div>
                    <div class="col-span-1 p-4 bg-white border border-gray-100 rounded-md shadow-sm">
                        <h5 class="text-sm font-semibold text-gray-400">Monto canjeado</h5>
                        <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">${{ number_format($result['totals']['redeemed_amount']) }} </span>
                    </div>
                    <div class="col-span-1 p-4 bg-white border border-gray-100 rounded-md shadow-sm">
                        <h5 class="text-sm font-semibold text-gray-400">Promedio por cupón:</h5>
                        <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">${{ number_format($result['totals']['average_amount'], 3) }} </span>
                    </div>
                </div>

                <div class="mt-8 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <h5 class="text-sm font-medium text-gray-500 md:text-base">Detallado de cupones canjeados</h5>
                        <div class="mt-3 overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize md:text-sm">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize md:text-sm">
                                    Usuario
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize md:text-sm">
                                    Cupón
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize md:text-sm">
                                    Impreso
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize md:text-sm">
                                    Canjeado
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize md:text-sm">
                                    Monto canje
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize md:text-sm">
                                    Saldo usuario
                                </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($result['coupons'] as $i => $data)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $i + 1 }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none rounded-full">
                                            {{ $data['user'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        <span class="inline-flex items-center justify-center px-2 py-1 mr-2 font-bold leading-none rounded-full text-xxs text-orange bg-orange-light">
                                            {{ $data['coupon_code'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-semibold leading-none rounded-full">
                                            {{ $data['date_coupon'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-semibold leading-none rounded-full">
                                            {{ $data['date_redeem'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        <span class="inline-flex items-center justify-center px-2 py-1 mr-2 font-bold leading-none text-green-600 bg-green-100 rounded-full text-xxs">
                                            ${{ number_format($data['amount_redeem'], 2) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        <span class="inline-flex items-center justify-center px-2 py-1 mr-2 font-bold leading-none text-blue-700 bg-blue-100 rounded-full text-xxs">
                                            ${{ number_format($data['user_balance'], 2) }}
                                        </span>
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

