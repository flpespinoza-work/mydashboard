<div>
    <div class="flex items-end" style="margin-top: -5.6rem;">
        <form class="items-end justify-end flex-1 md:flex" wire:submit.prevent="generateReport">
            <div class="px-2 space-y-2 md:w-3/12">
                <label for="store" class="text-xs font-semibold text-gray-600 hidden">Establecimiento</label>
                <select
                    wire:model.defer="filters.store"
                    id="store"
                    autocomplete="store"
                    class="block w-full p-2 mt-1 text-sm font-semibold border-gray-300 rounded-md bg-gray-50 focus:outline-none focus:ring-gray-200 focus:border-gray-300">
                    <option>Selecciona un establecimiento</option>
                    @foreach ($stores as $store => $name)
                    <option value="{{ $store }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="px-2 space-y-2 md:w-1/5">
                <label for="date" class="text-xs font-semibold text-gray-600 hidden">Fecha o Periodo</label>
                <div class="relative">
                    <x-heroicon-o-calendar class="absolute w-4 h-4 text-gray-500 top-3 left-2"/>
                    <input
                        type="text"
                        id="date"
                        readonly
                        class="block w-full p-2 pl-8 mt-1 text-sm font-semibold text-gray-500 border-gray-300 rounded-md bg-gray-50 focus:outline-none focus:ring-gray-200 focus:border-gray-300">
                </div>
            </div>

            <div class="px-2">
                <button type="submit" class="flex items-center px-5 py-2 text-sm font-semibold border rounded-md bg-orange border-orange-light text-gray-50">
                    <span wire:loading wire:target="generateReport" class="mr-2">
                        <x-loader class="w-5 h-5"/>
                    </span>
                    Generar reporte
                </button>
            </div>
        </form>

        <div class="w-1/5 hidden">
            @if(!is_null($result))
            <button wire:click="exportReport" type="button"  class="flex items-center px-5 py-2 ml-auto text-sm font-semibold bg-green-600 border border-green-700 rounded-md hover:bg-green-700 text-green-50">
                <x-heroicon-s-document-download class="w-4 h-4 md:h-5 md:w-5" />
                <span>Descargar</span>
            </button>
            @endif
        </div>
    </div>
    <div class="min-h-full mt-14">
        @if (!is_null($result))
            <div class="grid grid-cols-2 gap-4 mt-8 md:grid-cols-4">
                <div class="col-span-1 p-4 bg-white border border-gray-100 rounded-md shadow-sm">
                    <h5 class="text-sm font-semibold text-gray-400">Cupones impresos</h5>
                    <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">{{ $result['totals']['printed_coupons'] }} </span>
                </div>
                <div class="col-span-1 p-4 bg-white border border-gray-100 rounded-md shadow-sm">
                    <h5 class="text-sm font-semibold text-gray-400">Dinero impreso:</h5>
                    <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">${{ number_format($result['totals']['printed_amount'], 3) }} </span>
                </div>
                <div class="col-span-1 p-4 bg-white border border-gray-100 rounded-md shadow-sm">
                    <h5 class="text-sm font-semibold text-gray-400">Promedio por cupón:</h5>
                    <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">${{ $result['totals']['average_amount'] }} </span>
                </div>
                <div class="col-span-1 p-4 bg-white border border-gray-100 rounded-md shadow-sm">
                    <h5 class="text-sm font-semibold text-gray-400">Promedio de venta:</h5>
                    <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">${{ $result['totals']['average_sale'] }} </span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-8">
                <div class="h-40 col-span-2 p-4 border rounded-md shadow-sm bg-gray-25 border-gray-50 md:col-span-1 md:h-80">
                    <livewire:livewire-area-chart :area-chart-model="$couponsChartModel" :wire:key="time()"/>
                </div>
                <div class="h-40 col-span-2 p-4 border rounded-md shadow-sm bg-gray-25 border-gray-50 md:col-span-1 md:h-80">
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
                                        Cupones impresos
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                                        Monto
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                                        Promedio de cupón
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                                        Promedio de venta
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
                                        {{ $data['count'] }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        ${{ number_format($data['amount'], 3) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        ${{ $data['average_coupon'] }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        ${{ $data['average_sale'] }}
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
                                        <span class="font-semibold text-gray-darker">Cupones totales: {{ $result['totals']['printed_coupons']}}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        <span class="font-semibold text-gray-darker">Monto total: ${{ number_format($result['totals']['printed_amount'], 2) }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        <span class="font-semibold text-gray-darker">Promedio cupón: ${{ number_format($result['totals']['average_amount'], 3) }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        <span class="font-semibold text-gray-darker">Promedio cupón: ${{ number_format($result['totals']['average_sale'], 3) }}</span>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <p class="mt-40 text-sm font-semibold text-center">No hay información que mostrar</p>
        @endif
    </div>
</div>

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        .daterangepicker .ranges li.active {
            background: #0a1410;
        }
        .daterangepicker td.active, .daterangepicker td.active:hover {
            background-color: #0a1410;
        }
    </style>
@endpush

@push('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
    $(function() {
        $('#date').daterangepicker({
            "locale": {
                "daysOfWeek": [
                    "Dom",
                    "Lun",
                    "Mar",
                    "Mier",
                    "Jue",
                    "Vie",
                    "Sab"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
            }
        });

        $('#date').daterangepicker({
            ranges: {
                'Hoy': [moment(), moment()],
                'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
                'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
                'Últimos 60 días': [moment().subtract(59, 'days'), moment()],
                'Últimos 90 días': [moment().subtract(89, 'days'), moment()]
            },
            "locale": {
                "format": "DD/MM/YYYY",
                "separator": " - ",
                "applyLabel": "Seleccionar",
                "cancelLabel": "Cancelar",
                "fromLabel": "De",
                "toLabel": "Hasta",
                "customRangeLabel": "Custom",
                "weekLabel": "W",
                "daysOfWeek": [
                    "Dom",
                    "Lun",
                    "Mar",
                    "Mier",
                    "Jue",
                    "Vie",
                    "Sab"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
                "firstDay": 1
            },
            "showCustomRangeLabel": false,
            "alwaysShowCalendars": true,
            "autoApply": true,
            "startDate": moment(),
            "endDate": moment()
        });

        $('#date').on('apply.daterangepicker', function(ev, picker) {
            @this.set('filters.initial_date', picker.startDate.format('YYYY-MM-DD'));
            @this.set('filters.final_date', picker.endDate.format('YYYY-MM-DD'));
        });
    });
    </script>


@endpush
