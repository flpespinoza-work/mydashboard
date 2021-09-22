<div
x-data="{ showStoreList: @entangle('showStores') }"
>
    <form wire:submit.prevent="sendFiltersToReport" class="items-center space-y-2 md:space-y-0 md:space-x-4 xl:justify-end md:flex">
        <!--
        <div class="md:w-5/12 lg:w-5/12 xl:w-6/12">
            <select
                wire:model="store"
                id="store"
                class="{{ $errors->has('store') ? 'border-red-300 bg-red-50' : '' }} w-full text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200">
                <option value="" selected>Seleccione un establecimiento...</option>
                @foreach ($stores as $id => $store)
                    <option value="{{ $id }}">{{ $store }}</option>
                @endforeach
            </select>
        </div>
        -->
        <div class="relative md:w-6/12 lg:w-5/12 xl:w-5/12">
            <div class="relative w-full">
                <input
                x-on:click="showStoreList = true"
                x-ref="search"
                wire:model="selectedStore"
                placeholder="Seleccione un establecimiento"
                type="text"
                class="{{ $errors->has('filters.store') ? 'border-red-300 bg-red-50' : '' }} w-full text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200">
                @if (!$selectedStore)
                    <x-heroicon-s-chevron-down x-on:click="showStoreList = true" class="absolute right-0 w-5 h-5 mr-2 text-gray-400 transform -translate-y-1/2 top-1/2"/>
                @else
                    <span class="absolute right-0 inline-block transform -translate-y-1/2 top-1/2" x-on:click="$refs.search.focus()" wire:click="clearStore">
                        <x-heroicon-s-x class="w-5 h-5 mr-2 text-gray-400"/>
                    </span>
                @endif

            </div>
            <div x-show="showStoreList" @click.away="showStoreList = false" class="absolute z-50 w-full p-2 mt-1 overflow-y-auto bg-white border border-gray-200 max-h-72">
                @forelse ($stores as $id => $store)
                    <button
                        type="button"
                        wire:click="selectStore({{$id}}, '{{trim($store)}}')"
                        class="inline-block w-full px-1 py-2 text-xs text-left hover:bg-gray-100 focus:bg-gray-100 focus:outline-none focus:ring-0">{{ trim($store) }}</button>
                @empty
                    <button type="button" class="inline-block w-full px-1 py-2 text-xs text-left hover:bg-gray-100">No se encontraron establecimientos</button>
                @endforelse
            </div>
        </div>

        <div class="relative md:w-4/12 lg:w-5/12 xl:w-4/12">
            <input
            type="text"
            id="date_range"
            class="w-full text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200">
            <x-heroicon-o-calendar class="absolute right-0 w-5 h-5 mr-2 text-gray-400 transform -translate-y-1/2 top-1/2"/>
        </div>

        <div class="md:w-5/12 lg:w-5/12 xl:w-6/12">
            <select wire:change="selectSeller($event.target.value)"
                id="seller"
                class="w-full text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200">
                <option value="" selected>Seleccione un vendedor...</option>
                @if(!empty($sellers))
                    @foreach ($sellers as $seller)
                        <option value="{{ $seller }}">{{ $seller }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="md:w-2/12">
            <button type="submit"
                class="w-full py-2 text-xs font-semibold text-white border rounded-md border-orange-light bg-orange">Buscar</button>
        </div>
    </form>
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

