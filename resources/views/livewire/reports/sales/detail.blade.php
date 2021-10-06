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

                    <a
                        class="px-4 py-2 ml-auto text-sm font-semibold bg-green-600 rounded-md hover:bg-green-800 text-gray-50"
                        target="_blank"
                        href="{{ route('reports.sales.detail.download', ['data' => Crypt::encrypt(['report_id' => $result['report_id'], 'report_data' => $report_data])] ) }}"
                    >
                        <svg class="inline-block w-4 h-4" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 512 512" fill="currentColor"><path d="M453.546814,273.4485474h-81.4267578l0.000061-40.7133179h81.4266968V273.4485474z M453.546814,296.7133179h-81.4266968l-0.000061,40.7133789h81.4267578V296.7133179z M453.546814,104.7789307h-81.4266968l-0.000061,40.7133789h81.4267578V104.7789307z M453.546814,168.7570801h-81.4266968l-0.000061,40.7133789h81.4267578V168.7570801z M453.546814,360.6914673h-81.4266968l-0.000061,40.7133789h81.4267578V360.6914673z M509.7894897,440.9549561c-2.3264771,12.0977173-16.8670044,12.3884888-26.5800171,12.7956543h-180.883606v52.3457031h-36.1185913L0,459.5667725V52.491333L267.7775879,5.9036255h34.5482178v46.3553734L476.986084,52.258667c9.8294067,0.4071655,20.647522-0.2907715,29.1973267,5.5835571C512.1740723,66.4501953,511.5928345,77.3846436,512,87.2722168l-0.2330322,302.7910767C511.4761353,406.9884033,513.3373413,424.2625122,509.7894897,440.9549561z M213.2798462,349.6988525c-16.0526733-32.5706787-32.3961792-64.9087524-48.3907471-97.4794312c15.8200684-31.6982422,31.4074707-63.5128174,46.9367065-95.3273926c-13.2027588,0.6397705-26.4055176,1.4540405-39.5501099,2.3846436c-9.8293457,23.9046021-21.2872925,47.1693726-28.9646606,71.8881836c-7.1539307-23.322937-16.6343384-45.7734375-25.300415-68.5147705c-12.7956543,0.697937-25.5912476,1.4540405-38.3869019,2.210144c13.4935913,29.7789307,27.8595581,59.1506958,40.9459839,89.104126c-15.4129028,29.0809326-29.8370361,58.5690308-44.784668,87.8245239c12.7374268,0.5234375,25.4749146,1.046875,38.2124023,1.2213745c9.0732422-23.1484375,20.3566895-45.4244995,28.2666626-69.038208c7.0957642,25.3585815,19.1353149,48.7978516,29.0228271,73.0513916C185.3039551,348.012207,199.2628174,348.8846436,213.2798462,349.6988525z M484.2601929,79.8817749H302.3258057l-0.000061,24.8971558h46.529541v40.7133789h-46.529541v23.2647705h46.529541v40.7133789h-46.529541v23.2647705h46.529541v40.7133179h-46.529541v23.2647705h46.529541v40.7133789h-46.529541v23.2647705h46.529541v40.7133789h-46.529541v26.8971558h181.9344482V79.8817749z"></path></svg>
                        <span class="hidden ml-1 md:inline-block">Descargar</span>
                    </a>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-8 md:grid-cols-4">
                    <div class="col-span-1 p-4 border border-gray-100 rounded-sm bg-gray-50">
                        <h5 class="text-sm font-semibold text-gray-400">Ventas totales</h5>
                        <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">{{ number_format($result['totals']['sales']) }} </span>
                    </div>
                    <div class="col-span-1 p-4 border border-gray-100 rounded-sm bg-gray-50">
                        <h5 class="text-sm font-semibold text-gray-400">Monto total</h5>
                        <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">${{ number_format($result['totals']['amount']) }} </span>
                    </div>
                </div>

                <div class="mt-8 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                                            Fecha de Venta
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                                            Usuario
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                                            Monto de venta
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse (array_reverse($result['sales']) as $data)
                                    <tr>
                                        <td class="px-6 py-3 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $data['date'] }}
                                        </td>
                                        <td class="px-6 py-3 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $data['user'] }}
                                        </td>
                                        <td class="px-6 py-3 text-sm text-gray-500 whitespace-nowrap">
                                            ${{ number_format($data['amount'],2) }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td class="px-6 py-3 text-sm text-gray-500 whitespace-nowrap">
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


