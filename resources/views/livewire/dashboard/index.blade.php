<div>
    <x-slot name="actions">
        <livewire:reports.filters :report="$reportName"/>
    </x-slot>
    <div class="flex flex-col mt-7">
        <div class="grid grid-cols-4 gap-2 md:gap-4 lg:gap-5">
            <div class="col-span-2 p-3 rounded-md drop-shadow-sm bg-gray-50 sm:col-span-2 md:col-span-1">
                <h5 class="text-xs font-light text-gray-500 lg:text-sm">Saldo</h5>
                <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">$123,456.00</p>
            </div>
            <div class="col-span-2 p-3 rounded-md drop-shadow-sm bg-gray-50 sm:col-span-2 md:col-span-1 ">
                <h5 class="text-xs font-light text-gray-500 lg:text-sm">Cupones impresos</h5>
                <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">123,456</p>
            </div>
            <div class="col-span-2 p-3 rounded-md drop-shadow-sm bg-gray-50 sm:col-span-2 md:col-span-1 ">
                <h5 class="text-xs font-light text-gray-500 lg:text-sm">Cupones canjeados</h5>
                <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">3,456</p>
            </div>
            <div class="col-span-2 p-3 rounded-md drop-shadow-sm bg-gray-50 sm:col-span-2 md:col-span-1 ">
                <h5 class="text-xs font-light text-gray-500 lg:text-sm">Impreso vs Canjeado</h5>
                <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">15.34%</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-2 mt-4 md:gap-4 lg:gap-5">
            <div class="grid grid-cols-2 col-span-2 gap-2 md:col-span-1 md:gap-4 lg:gap-5">
                <div class="col-span-1 p-3 rounded-md drop-shadow-sm bg-gray-50 md:col-span-1">
                    <h5 class="text-xs font-light text-gray-500 lg:text-sm">Dinero impreso</h5>
                    <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">123,456</p>
                </div>
                <div class="col-span-1 p-3 rounded-md drop-shadow-sm bg-gray-50 md:col-span-1">
                    <h5 class="text-xs font-light text-gray-500 lg:text-sm">Dinero canjeado</h5>
                    <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">3,456</p>
                </div>
                <div class="col-span-1 p-3 rounded-md drop-shadow-sm bg-gray-50 md:col-span-1">
                    <h5 class="text-xs font-light text-gray-500 lg:text-sm">Dinero impreso vs canje(%)</h5>
                    <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">15.34%</p>
                </div>
                <div class="col-span-1 p-3 rounded-md drop-shadow-sm bg-gray-50 md:col-span-1">
                    <h5 class="text-xs font-light text-gray-500 lg:text-sm">Eventos de redención(pagos)</h5>
                    <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">15.34%</p>
                </div>
            </div>

            <div class="col-span-2 bg-red-100 md:col-span-1">
            <!--Grafica-->Canjes
            </div>
        </div>

        <div class="grid grid-cols-2 gap-2 mt-4 md:gap-4 lg:gap-5">
            <div class="col-span-2 bg-red-100 md:col-span-1">
            <!--Grafica-->Usuarios
            </div>

            <div class="grid grid-cols-2 col-span-2 gap-2 md:col-span-1 md:gap-4 lg:gap-5">
                <div class="col-span-1 p-3 rounded-md drop-shadow-sm bg-gray-50 md:col-span-1">
                    <h5 class="text-xs font-light text-gray-500 lg:text-sm">Dinero Redenciones Reales</h5>
                    <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">123,456</p>
                </div>
                <div class="col-span-1 p-3 rounded-md drop-shadow-sm bg-gray-50 md:col-span-1">
                    <h5 class="text-xs font-light text-gray-500 lg:text-sm">Dinero Redimido / Canje</h5>
                    <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">3,456</p>
                </div>
                <div class="col-span-1 p-3 rounded-md drop-shadow-sm bg-gray-50 md:col-span-1">
                    <h5 class="text-xs font-light text-gray-500 lg:text-sm">Promedio por redención</h5>
                    <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">15.34%</p>
                </div>
            </div>
        </div>

    </div>
</div>
