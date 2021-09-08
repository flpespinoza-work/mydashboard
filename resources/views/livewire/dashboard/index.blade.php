<div>
    <x-slot name="actions">
        <livewire:reports.filters :report="$reportName"/>
    </x-slot>
    <div class="flex flex-col mt-7">
        <div class="grid grid-cols-4 gap-2 md:gap-4 lg:gap-5">
            <div class="col-span-2 p-3 rounded-md drop-shadow-sm bg-gray-50 sm:col-span-2 md:col-span-1">
                <h5 class="text-xs font-light text-gray-500 lg:text-sm">Saldo</h5>
                <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl">$123,456.00</p>
            </div>
            <div class="col-span-2 p-3 rounded-md drop-shadow-sm bg-gray-50 sm:col-span-2 md:col-span-1 ">
                <h5 class="text-xs font-light text-gray-500 lg:text-sm">Cupones impresos</h5>
                <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl">123,456</p>
            </div>
            <div class="col-span-2 p-3 rounded-md drop-shadow-sm bg-gray-50 sm:col-span-2 md:col-span-1 ">
                <h5 class="text-xs font-light text-gray-500 lg:text-sm">Cupones canjeados</h5>
                <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl">3,456</p>
            </div>
            <div class="col-span-2 p-3 rounded-md drop-shadow-sm bg-gray-50 sm:col-span-2 md:col-span-1 ">
                <h5 class="text-xs font-light text-gray-500 lg:text-sm">Impreso vs Canjeado</h5>
                <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl">15.34%</p>
            </div>
        </div>
        <div class="grid grid-cols-2 grid-rows-2 gap-2 mt-4 md:gap-4 lg:gap-5">
            <div class="grid grid-cols-2 col-span-2 gap-2 md:col-span-1 md:gap-4 lg:gap-5">
                <div class="col-span-1 p-3 rounded-md drop-shadow-sm bg-gray-50 md:col-span-1">
                    <h5 class="text-xs font-light text-gray-500 lg:text-sm">Cupones impresos</h5>
                    <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl">123,456</p>
                </div>
                <div class="col-span-1 p-3 rounded-md drop-shadow-sm bg-gray-50 md:col-span-1">
                    <h5 class="text-xs font-light text-gray-500 lg:text-sm">Cupones canjeados</h5>
                    <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl">3,456</p>
                </div>
                <div class="col-span-1 p-3 rounded-md drop-shadow-sm bg-gray-50 md:col-span-1">
                    <h5 class="text-xs font-light text-gray-500 lg:text-sm">Impreso vs Canjeado</h5>
                    <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl">15.34%</p>
                </div>
                <div class="col-span-1 p-3 rounded-md drop-shadow-sm bg-gray-50 md:col-span-1">
                    <h5 class="text-xs font-light text-gray-500 lg:text-sm">Impreso vs Canjeado</h5>
                    <p class="mt-2 text-sm font-semibold md:text-lg lg:text-xl">15.34%</p>
                </div>
            </div>

            <div class="col-span-2 mt-4 bg-red-300 md:col-span-1">

            </div>
        </div>
    </div>
</div>
