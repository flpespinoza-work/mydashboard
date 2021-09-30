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
                    <div class="col-span-1 p-2 rounded md:col-span-1 bg-gray-50">
                        <p class="font-semibold uppercase">Información del usuario</p>
                        <p class="flex flex-col mt-2 space-y-1 text-xs text-gray-600 md:text-base">
                            <span class="block font-medium">NUN ID: <span class="font-normal text-gray-500">{{ $result['info']->NODO}}</span></span>
                            <span class="block font-medium">Nombre: <span class="font-normal text-gray-500">{{ $result['info']->NOMBRE}}</span></span>
                            <span class="block font-medium">Teléfono: <span class="font-normal text-gray-500">{{ $result['info']->NUMERO}}</span></span>
                            <span class="block font-medium">Correo: <span class="font-normal text-gray-500">{{ $result['info']->CORREO}}</span></span>
                            <span class="block font-medium">Alta: <span class="font-normal text-gray-500">{{ $result['info']->FECHA_ALTA}}</span></span>
                            <span class="block font-medium">Estado: <span class="font-normal text-gray-500">Activo</span></span>
                        </p>
                    </div>
                    <div class="col-span-2 p-2 md:col-span-2">

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
