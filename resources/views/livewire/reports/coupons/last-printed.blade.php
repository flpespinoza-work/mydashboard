<div>
    @if (!is_null($result) && !empty($result))
    <div class="mt-4 -my-2 overflow-x-auto lg:mt-8 sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                                Establecimiento
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                                Fecha-Hora último cupón impreso
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 capitalize">
                                Monto del cupón
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($result as $coupon)
                        <tr class="@if($coupon->diff >= 10) bg-red-50 @endif">
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                {{ $coupon->store_name }}
                            </td>
                            <td class="px-6 py-4 text-sm whitespace-nowraptext-gray-500">
                                {{ $coupon->date }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                ${{ number_format($coupon->amount, 2) }}
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
    @endif
</div>
