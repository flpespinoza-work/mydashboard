<div>
    <div class="p-3 rounded-md shadow-sm bg-gray-25">
        <form class="items-end justify-end w-full md:flex" wire:submit.prevent="generateReport">
            <div class="px-2 space-y-2 md:w-1/3">
                <label for="store" class="block text-sm font-medium text-gray-700">Selecione un establecimiento</label>
                <select wire:model.defer="filters.store" id="store" name="store" autocomplete="store" class="block w-full p-3 mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option></option>
                    @foreach ($stores as $store => $name)
                    <option value="{{ $store }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="px-2 space-y-2 md:w-1/3">
                <label for="store" class="block text-sm font-medium text-gray-700">Seleccione la fecha o periodo</label>
                <div class="relative">
                    <x-heroicon-s-calendar class="absolute w-5 h-5 text-gray-400 top-2 left-2"/>
                    <input type="text" id="date" class="block w-full py-3 pl-10 mt-1 bg-gray-100 border-gray-300 rounded-md shadow-sm sm:text-sm">
                </div>
            </div>

            <div class="px-2 md:w-1/3">
                <button type="submit" class="flex items-center w-full px-5 py-3 text-sm font-semibold rounded-md bg-orange text-gray-50">
                    <span>Generar reporte</span>
                </button>
            </div>
        </form>
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
