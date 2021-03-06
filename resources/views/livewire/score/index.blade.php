<div
    x-data="{ scrollAtTop: true}"
    >
    <x-slot name="actions">
        <livewire:score.score-filters />
    </x-slot>

    <div class="min-h-full mt-4 lg:mt-8">
        <div wire:loading.delay class="w-full">
            <p class="text-xs font-semibold text-center md:text-sm">
                <x-loader class="w-10 h-10" />
                Obteniendo información...
            </p>
        </div>

        @if(!is_null($scores) && !empty($scores))
        <div
            wire:loading.remove>
            <div>
                <h3 class="text-sm font-semibold text-gray-600 md:text-lg lg:text-xl">Establecimiento: {{ $report_data['store'] }}</h3>
                <h5 class="text-xs font-medium text-gray-500 md:text-base">{{ $report_data['period'] }}</h5>
                @if ($report_data['seller'])
                    <h5 class="text-xs font-medium text-gray-500 md:text-base">Vendedor: {{ $report_data['seller']}}</h5>
                @endif
            </div>
            <div class="space-y-4 mt-7">
                <div class="grid grid-cols-4 gap-4">
                    <div class="col-span-2 p-4 border border-gray-100 rounded-sm md:col-span-1 bg-gray-50">
                        <h5 class="text-xs font-semibold text-gray-400 md:text-sm">Calificaciones totales:</h5>
                        <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">{{ $scores['totalScores'] }} </span>
                    </div>
                    <div class="col-span-2 p-4 border border-gray-100 rounded-sm md:col-span-1 bg-gray-50">
                        <h5 class="text-xs font-semibold text-gray-400 md:text-sm">Promedio:</h5>
                        <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">{{ $scores['scorePromedio'] }}% </span>
                    </div>
                    <div class="col-span-2 p-4 border border-gray-100 rounded-sm md:col-span-1 bg-gray-50">
                        <h5 class="text-xs font-semibold text-gray-400 md:text-sm">Total de comentarios:</h5>
                        <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">{{ number_format($scores['totalComments']) }} </span>
                    </div>
                    <div class="col-span-2 p-4 border border-gray-100 rounded-sm md:col-span-1 bg-gray-50">
                        <h5 class="text-xs font-semibold text-gray-400 md:text-sm">Porcentaje de comentarios:</h5>
                        <span class="inline-block mt-2 text-lg font-semibold text-gray-darker md:text-xl xl:text-3xl">{{ number_format($scores['totalComments'] * 100 / $scores['totalScores'],2) }}% </span>
                    </div>
                </div>
                <div id="charts" class="grid grid-cols-2 gap-4 mt-8">
                    <div class="col-span-2 md:col-span-1 h-60 md:h-96">
                        <div class="flex items-center h-full">
                            <div class="justify-between space-y-1 md:space-y-3 flex-flex-col">
                                <x-scores.5 class="w-8 h-8 md:w-12 md:h-12" />
                                <x-scores.4 class="w-8 h-8 md:w-12 md:h-12" />
                                <x-scores.3 class="w-8 h-8 md:w-12 md:h-12" />
                                <x-scores.2 class="w-8 h-8 md:w-12 md:h-12" />
                                <x-scores.1 class="w-8 h-8 md:w-12 md:h-12" />
                            </div>
                            <livewire:livewire-column-chart key="{{ $columnChartModel->reactiveKey() }}" :column-chart-model="$columnChartModel"/>
                        </div>
                    </div>
                    <div class="col-span-2 md:col-span-1 h-60 md:h-96">
                        <livewire:livewire-column-chart key="{{ $columnChartModelScore->reactiveKey() }}" :column-chart-model="$columnChartModelScore"/>
                    </div>
                </div>
            </div>

            <div id="comments" class="mt-8">
                <h4 class="text-sm text-center text-gray-700 md:text-lg xl:text-xl">Comentarios</h4>
                <div x-data="{ openTab: 5 }" class="mt-4">
                    <div class="w-full">
                        <ul class="flex items-center justify-between overflow-auto border rounded-sm flex-nowrap border-gray-150">
                            <li @click="openTab = 5" :class="openTab === 5 ? 'bg-gray-25' : 'bg-orange-lightest'"
                                class="flex-shrink-0 border-r w-28 h-14 md:flex-1 border-gray-150">
                                <a class="flex items-center justify-center w-full h-full cursor-pointer">
                                    <x-scores.5 class="w-12 h-12" />
                                    <span class="text-xs font-medium">{{ $scores['count5'] }}</span>
                                </a>
                            </li>
                            <li @click="openTab = 4" :class="openTab === 4 ? 'bg-gray-25' : 'bg-orange-lightest'"
                                class="flex-shrink-0 border-r w-28 h-14 md:flex-1 border-gray-150 ">
                                <a class="flex items-center justify-center w-full h-full cursor-pointer">
                                    <x-scores.4 class="w-12 h-12" />
                                    <span class="text-xs font-medium">{{ $scores['count4'] }}</span>
                                </a>
                            </li>
                            <li @click="openTab = 3" :class="openTab === 3 ? 'bg-gray-25' : 'bg-orange-lightest'"
                                class="flex-shrink-0 border-r w-28 h-14 md:flex-1 border-gray-150">
                                <a class="flex items-center justify-center w-full h-full cursor-pointer">
                                    <x-scores.3 class="w-12 h-12" />
                                    <span class="text-xs font-medium">{{ $scores['count3'] }}</span>
                                </a>
                            </li>
                            <li @click="openTab = 2" :class="openTab === 2 ? 'bg-gray-25' : 'bg-orange-lightest'"
                                class="flex-shrink-0 border-r w-28 h-14 md:flex-1 border-gray-150">
                                <a class="flex items-center justify-center w-full h-full cursor-pointer">
                                    <x-scores.2 class="w-12 h-12" />
                                    <span class="text-xs font-medium">{{ $scores['count2'] }}</span>
                                </a>
                            </li>
                            <li @click="openTab = 1" :class="openTab === 1 ? 'bg-gray-25' : 'bg-orange-lightest'"
                                class="flex-shrink-0 border-r w-28 h-14 md:flex-1 border-gray-150">
                                <a class="flex items-center justify-center w-full h-full cursor-pointer">
                                    <x-scores.1 class="w-12 h-12" />
                                    <span class="text-xs font-medium">{{ $scores['count1'] }}</span>
                                </a>
                            </li>
                            <li @click="openTab = 0" :class="openTab === 0 ? 'bg-gray-25' : 'bg-orange-lightest'"
                                class="flex-shrink-0 w-60 h-14 md:flex-1">
                                <a class="flex items-center justify-center w-full h-full text-xs font-semibold leading-snug cursor-pointer md:text-xxs lg:text-sm">
                                    <span>Solo comentarios</span>
                                    <span class="ml-2 text-xs font-medium">{{ $scores['count0'] }}</span>
                                </a>
                            </li>
                        </ul>
                        <div class="px-4 py-8 border border-t-0 border-gray-150 ">
                            @foreach (range(5,0) as $value)
                                @if (isset($scores['comments'][$value]))
                                    @php $hide = 0; $show = 0;  @endphp
                                    <div id="score-{{$value}}" x-show="openTab === {{ $value }}">
                                        @foreach ($scores['comments'][$value] as $comment)
                                            @if(strpos($comment['comment'], 'tus comentarios') !== true)
                                                @if (strlen($comment['comment']) <= 3)
                                                    @php $hide++; continue; @endphp
                                                @else
                                                    @php $show++; @endphp
                                                @endif
                                            <div class="p-3 mx-auto my-2 border rounded-md md:w-3/4 border-gray-150">
                                                <div class="flex flex-wrap items-center">
                                                    <span class="inline-block w-auto px-2 font-bold bg-yellow-500 rounded text-xxs max-w-max md:mr-4 text-gray-50">{{ $show }}</span>
                                                    <span class="ml-2 font-semibold text-gray-500 text-xxs sm:text-xs">Usuario: {{ $comment['user']}}</span>
                                                    <span class="mx-2 font-medium text-gray-400 md:mx-6 text-xxs md:text-xs">{{ $comment['date']}}</span>
                                                    @if (strpos($comment['action'], 'Pago') !== false)
                                                        <span class="text-xxs max-w-max inline-block tracking-wide font-medium py-0.5 px-3 rounded-full bg-red-100 text-red-500">
                                                            {{ Str::lower($comment['action']) }}
                                                        </span>
                                                    @else
                                                        <span class="text-xxs max-w-max inline-block tracking-wide font-medium py-0.5 px-3 rounded-full bg-green-100 text-green-500">
                                                            {{ Str::lower($comment['action']) }}
                                                        </span>
                                                    @endif

                                                    <span class="font-medium text-gray-400 md:ml-auto text-xxs">Atendio: {{ $comment['seller']}}</span>
                                                </div>
                                                <div class="p-3 mt-3 rounded-sm bg-gray-50">
                                                    <p class="text-xs font-medium text-gray-500 md:text-sm">{{ $comment['comment'] }}</p>
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                        @if($hide > 0)
                                        <p class="w-full mt-8">
                                           <span class="relative block w-full py-2 mx-auto text-xs font-semibold text-center bg-yellow-100 rounded md:w-3/4">Se ocultaron {{ $hide }} comentarios cortos</span>
                                        </p>
                                        @endif
                                    </div>
                                @else
                                    <div id="score-{{$value}}" x-show="openTab === {{ $value }}">
                                        <p class="text-xs font-medium text-center md:text-sm">No hay comentarios para esta calificación</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
            <div wire:loading.remove>
                @if (!is_null($scores) && empty($scores))
                    <p class="text-xs font-semibold text-center md:text-sm">No hay resultados para la busqueda</p>
                @else
                   <p class="text-xs font-semibold text-center md:text-sm">No hay información que mostrar</p>
                @endif
            </div>
        @endif
    </div>
</div>
