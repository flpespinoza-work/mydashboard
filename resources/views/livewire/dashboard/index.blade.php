<div>
    <x-slot name="actions">
        <livewire:reports.filters :report="$reportName"/>
    </x-slot>
    <div wire:loading.delay class="w-full">
        <p class="text-xs font-semibold text-center md:text-sm">
            <x-loader class="w-10 h-10" />
            Obteniendo información...
        </p>
    </div>
    <div class="flex flex-col mt-7">
        <h3 class="text-sm font-semibold text-gray-600 md:text-lg lg:text-xl">Establecimiento: {{ $store_name }}</h3>
        <div class="grid grid-cols-4 gap-2 mt-4 md:gap-4 lg:gap-5">
            <div class="col-span-2 p-3 rounded-md drop-shadow-sm bg-gray-50 sm:col-span-2 md:col-span-1 ">
                <h5 class="text-xs font-light text-gray-500 lg:text-sm">Cupones impresos</h5>
                <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">{{ number_format($result['printed_coupons']['coupons']) }}</p>
            </div>
            <div class="col-span-2 p-3 rounded-md drop-shadow-sm bg-gray-50 sm:col-span-2 md:col-span-1 ">
                <h5 class="text-xs font-light text-gray-500 lg:text-sm">Cupones canjeados</h5>
                <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">{{ number_format($result['redeemed_coupons']['redeems']) }}</p>
            </div>
            <div class="col-span-2 p-3 rounded-md drop-shadow-sm bg-gray-50 sm:col-span-2 md:col-span-1">
                <h5 class="text-xs font-light text-gray-500 lg:text-sm">Dinero impreso</h5>
                <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">${{ number_format($result['printed_coupons']['amount']) }}</p>
            </div>
            <div class="col-span-2 p-3 rounded-md drop-shadow-sm bg-gray-50 sm:col-span-2 md:col-span-1">
                <h5 class="text-xs font-light text-gray-500 lg:text-sm">Dinero canjeado</h5>
                <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">${{ number_format($result['redeemed_coupons']['amount']) }}</p>
            </div>
        </div>

        <div class="grid grid-cols-4 gap-2 mt-5 md:gap-4 lg:gap-5">
            <div class="col-span-2 p-3 rounded-md drop-shadow-sm bg-gray-50 sm:col-span-2 md:col-span-1">
                <h5 class="text-xs font-light text-gray-500 lg:text-sm">Dinero impreso vs canje(%)</h5>
                <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">
                    @if($result['redeemed_coupons']['amount'] > 0)
                    {{ number_format( ($result['redeemed_coupons']['amount'] / $result['printed_coupons']['amount']) * 100, 2 ) }}%
                    @else
                    0 %
                    @endif
                </p>
            </div>
            <div class="col-span-2 p-3 rounded-md drop-shadow-sm bg-gray-50 sm:col-span-2 md:col-span-1">
                <h5 class="text-xs font-light text-gray-500 lg:text-sm">Eventos de redención(pagos)</h5>
                <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">{{ number_format($result['sales']['sales']) }}</p>
            </div>
            <div class="col-span-2 p-3 rounded-md drop-shadow-sm bg-gray-50 sm:col-span-2 md:col-span-1">
                <h5 class="text-xs font-light text-gray-500 lg:text-sm">Impreso vs Canjeado</h5>
                <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">
                    @if($result['redeemed_coupons']['redeems'] > 0)
                    {{ number_format( ($result['redeemed_coupons']['redeems'] / $result['printed_coupons']['coupons']) * 100 , 2) }}%
                    @else
                    0%
                    @endif
                </p>
            </div>
            <div class="col-span-2 p-3 rounded-md drop-shadow-sm bg-gray-50 sm:col-span-2 md:col-span-1">
                <h5 class="text-xs font-light text-gray-500 lg:text-sm">Dinero Redenciones Reales</h5>
                <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">${{ number_format($result['sales']['amount'])}}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-2 mt-4 md:gap-4 lg:gap-5">
            <div class="col-span-2 md:col-span-1 h-72">

                <livewire:livewire-column-chart
                key="{{ $usersChartModel->reactiveKey() }}"
                :column-chart-model="$usersChartModel"
                />
                <h5 class="text-xs text-center">Nuevos usuarios</h5>
            </div>


        </div>

    </div>
</div>
