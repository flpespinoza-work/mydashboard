<form wire:submit.prevent="sendFiltersToReport" class="items-center space-y-2 md:space-y-0 md:space-x-4 xl:justify-end md:flex">
    <div class="md:w-5/12 lg:w-5/12 xl:w-6/12">
        <select
            wire:model="selectedStore"
            id="store"
            class="{{ $errors->has('selectedStore') ? 'border-red-300 bg-red-50' : '' }} w-full text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200">
            <option value="" selected>Seleccione un establecimiento</option>
            @foreach ($stores as $id => $store)
            <option value="{{ $id }}">{{ $store }}</option>
            @endforeach
        </select>
    </div>
    <div class="relative md:w-4/12 lg:w-5/12 xl:w-4/12">
        <input
        type="text"
        id="date_range"
        class="w-full text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200">
        <x-heroicon-o-calendar class="absolute right-0 w-5 h-5 mr-2 text-gray-400 transform -translate-y-1/2 top-1/2"/>
    </div>
    <!-- div class="md:w-5/12 lg:w-5/12 xl:w-6/12">
        <select wire:model="selectedSeller"
            id="store"
            class="w-full text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200">
            <option value="" selected>Seleccione un vendedor</option>

        </select>
    </div -->
    <div class="md:w-2/12">
        <button type="submit"
            class="w-full py-2 text-xs font-semibold text-white border rounded-md border-orange-light bg-orange">Buscar</button>
    </div>
</form>

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
        $('#date_range').daterangepicker({
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
            "opens": "left",
            "showCustomRangeLabel": false,
            "alwaysShowCalendars": true,
            "autoApply": true,
            "startDate": moment(),
            "endDate": moment()
        });

        $('#date_range').on('apply.daterangepicker', function(ev, picker) {
            @this.set('initial_date', picker.startDate.format('YYYY-MM-DD'));
            @this.set('final_date', picker.endDate.format('YYYY-MM-DD'));
        });
    });
    </script>


@endpush

