<div>

    <x-slot name="actions">
        <livewire:reports.filters :report="$reportName" :hideDates="true"/>
    </x-slot>

    <div class="min-h-full mt-14">
        <div wire:loading.delay class="w-full">
            <p class="text-xs font-semibold text-center md:text-sm">
                <x-loader class="w-10 h-10" />
                Obteniendo información...
            </p>
        </div>

        @if (!is_null($result) && !empty($result))
            <div class="mt-8 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                                Ventas realizadas
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                                Saldo total vendido
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-500 lg:text-lg whitespace-nowrap">
                                {{ number_format($result['sales']) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 lg:text-lg whitespace-nowrap">
                                ${{ number_format($result['amount']) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
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

