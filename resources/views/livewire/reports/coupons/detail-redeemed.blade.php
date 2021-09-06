<div>
    <div class="flex items-end">
        <form class="items-end justify-start flex-1 md:flex" wire:submit.prevent="generateReport">
            <div class="px-2 space-y-2 md:w-1/5">
                <label for="store" class="block text-xs font-semibold text-gray-600">Establecimiento</label>
                <select
                    wire:model.defer="filters.store"
                    id="store"
                    autocomplete="store"
                    class="block w-full p-2 mt-1 text-sm font-semibold border-gray-300 rounded-md bg-gray-50 focus:outline-none focus:ring-gray-200 focus:border-gray-300">
                    <option>Selecciona...</option>
                    @foreach ($stores as $store => $name)
                    <option value="{{ $store }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="px-2 space-y-2 md:w-1/5">
                <label for="date" class="block text-xs font-semibold text-gray-600">Fecha o Periodo</label>
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

        <div class="w-1/5 ">
            @if(!is_null($result))
            <button wire:click="exportReport" type="button"  class="flex items-center px-5 py-2 ml-auto text-sm font-semibold bg-green-600 border border-green-700 rounded-md hover:bg-green-700 text-green-50">
                <x-heroicon-s-document-download class="w-4 h-4 md:h-5 md:w-5" />
                <span>Descargar</span>
            </button>
            @endif
        </div>
    </div>
    <div class="min-h-full mt-10">
        @if (!is_null($result))
            <div class="grid grid-cols-2 gap-4 mt-8 md:grid-cols-4">
                <div class="col-span-1 p-4 bg-white border border-gray-100 rounded-md shadow-sm">
                    <h5 class="text-sm font-semibold text-gray-400">Cupones canjeados</h5>
                    <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">{{ $result['totals']['redeemed_coupons'] }} </span>
                </div>
                <div class="col-span-1 p-4 bg-white border border-gray-100 rounded-md shadow-sm">
                    <h5 class="text-sm font-semibold text-gray-400">Monto canjeado</h5>
                    <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">${{ number_format($result['totals']['redeemed_amount'], 3) }} </span>
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
