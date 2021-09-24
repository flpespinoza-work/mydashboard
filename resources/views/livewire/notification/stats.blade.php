<div>
    <div class="flex items-center">
        <h3 class="text-sm font-semibold text-gray-600 md:text-lg lg:text-xl">Campaña: {{ $data->CAMP_NOMBRE }}</h3>
        <a class="px-3 py-2 ml-auto text-xs rounded bg-orange text-orange-lightest hover:shadow-sm" href="{{ route('notifications') }}">Volver a las campañas</a>
    </div>

    <div class="space-y-4 mt-7">
        <div class="grid grid-cols-4 gap-4">
            <div class="col-span-2 p-4 border border-gray-100 rounded-sm md:col-span-1 bg-gray-50">
                <h5 class="text-sm font-semibold text-gray-400">Exitosas:</h5>
                <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">{{ number_format($data->CAMP_EXITOSAS) }} </span>
            </div>
            <div class="col-span-2 p-4 border border-gray-100 rounded-sm md:col-span-1 bg-gray-50">
                <h5 class="text-sm font-semibold text-gray-400">Fallidas:</h5>
                <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">{{ number_format($data->CAMP_FALLIDAS) }} </span>
            </div>
            <div class="flex items-center col-span-2 p-4 border border-gray-100 rounded-sm md:col-span-1 bg-gray-50">
                <h5 class="text-sm font-semibold text-green-400">
                   <x-icons.android class="w-12 h-12"/>
                </h5>
                <span class="inline-block ml-4 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">{{ number_format($data->CAMP_ANDROID) }} </span>
            </div>
            <div class="flex items-center col-span-2 p-4 border border-gray-100 rounded-sm md:col-span-1 bg-gray-50">
                <h5 class="text-sm font-semibold text-blue-600">
                    <x-icons.ios class="w-12 h-12"/>
                </h5>
                <span class="inline-block ml-4 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">{{ number_format($data->CAMP_IOS) }} </span>
            </div>
        </div>

        <div class="grid grid-cols-4 gap-4">
            <div class="col-span-2 p-4 border border-gray-100 rounded-sm md:col-span-1 bg-gray-50">
                <h5 class="text-sm font-semibold text-gray-400">Leídas</h5>
                <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">{{ number_format($data->LEIDAS) }} </span>
            </div>
            <div class="col-span-2 p-4 border border-gray-100 rounded-sm md:col-span-1 bg-gray-50">
                <h5 class="text-sm font-semibold text-gray-400">No leídas</h5>
                <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">{{ number_format($data->NO_LEIDAS) }} </span>
            </div>
            <div class="col-span-2 p-4 border border-gray-100 rounded-sm md:col-span-1 bg-gray-50">
                <h5 class="text-sm font-semibold text-gray-400">Eliminadas</h5>
                <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">{{ number_format($data->ELIMINADAS) }} </span>
            </div>
        </div>


        <div id="charts" class="grid grid-cols-3 gap-4">
            <div class="col-span-3 p-3 md:col-span-1 h-60 md:h-96 bg-gray-50">
                <livewire:livewire-column-chart
                    key="{{ $mainColumnchart->reactiveKey() }}"
                    :column-chart-model="$mainColumnchart"
                />
            </div>
            <div class="col-span-3 md:col-span-1 h-60 md:h-96">
                <livewire:livewire-column-chart
                    key="{{ $deviceColumnchart->reactiveKey() }}"
                    :column-chart-model="$deviceColumnchart"
                />
            </div>
            <div class="col-span-3 md:col-span-1 h-60 md:h-96">
                <livewire:livewire-column-chart
                    key="{{ $actionsColumnChart->reactiveKey() }}"
                    :column-chart-model="$actionsColumnChart"
                />
            </div>
        </div>
    </div>
</div>
