<div>
    <livewire:score.score-filters />
    <div class="min-h-full mt-14">
        <div wire:loading.delay class="w-full">
            <p class="text-xs font-semibold text-center md:text-sm">
                <x-loader class="w-10 h-10" />
                Obteniendo información...
            </p>
        </div>
        <div class="space-y-4">

            <div id="charts" class="grid grid-cols-2 gap-4">
                <div class="col-span-2 md:col-span-1">uno</div>
                <div class="col-span-2 md:col-span-1">dos</div>
            </div>
        </div>
        @if(!is_null($scores) && !empty($scores))
        <div id="comments">
            <h4 class="text-sm md:text-lg xl:text-xl text-gray-400">Comentarios</h4>
            <div x-data="{ openTab: 5 }" class="mt-4">
                <div class="w-full">
                    <ul class="flex flex-nowrap items-center justify-between border border-gray-150 overflow-auto rounded-sm">
                        <li @click="openTab = 5" :class="openTab === 5 ? 'bg-gray-25' : 'bg-orange-lightest'"
                            class="w-28 h-14 md:flex-1 flex-shrink-0 border-r border-gray-150">
                            <a class="cursor-pointer w-full h-full flex items-center justify-center">
                                <x-scores.5 class="w-12 h-12 mx-auto" />
                            </a>
                        </li>
                        <li @click="openTab = 4" :class="openTab === 4 ? 'bg-gray-25' : 'bg-orange-lightest'"
                            class="w-28 h-14 md:flex-1 flex-shrink-0 border-r border-gray-150 ">
                            <a class="cursor-pointer w-full h-full flex items-center justify-center">
                                <x-scores.4 class="w-12 h-12 mx-auto" />
                            </a>
                        </li>
                        <li @click="openTab = 3" :class="openTab === 3 ? 'bg-gray-25' : 'bg-orange-lightest'"
                            class="w-28 h-14 md:flex-1 flex-shrink-0 border-r border-gray-150">
                            <a class="cursor-pointer w-full h-full flex items-center justify-center">
                                <x-scores.3 class="w-12 h-12 mx-auto" />
                            </a>
                        </li>
                        <li @click="openTab = 2" :class="openTab === 2 ? 'bg-gray-25' : 'bg-orange-lightest'"
                            class="w-28 h-14 md:flex-1 flex-shrink-0 border-r border-gray-150">
                            <a class="cursor-pointer w-full h-full flex items-center justify-center">
                                <x-scores.2 class="w-12 h-12 mx-auto" />
                            </a>
                        </li>
                        <li @click="openTab = 1" :class="openTab === 1 ? 'bg-gray-25' : 'bg-orange-lightest'"
                            class="w-28 h-14 md:flex-1 flex-shrink-0 border-r border-gray-150">
                            <a class="cursor-pointer w-full h-full flex items-center justify-center">
                                <x-scores.1 class="w-12 h-12 mx-auto" />
                            </a>
                        </li>
                        <li @click="openTab = 0" :class="openTab === 0 ? 'bg-gray-25' : 'bg-orange-lightest'"
                            class="w-60 h-14 md:flex-1 flex-shrink-0">
                            <a class="cursor-pointer w-full h-full flex items-center justify-center text-xs md:text-sm leading-snug font-semibold">Solo comentarios</a>
                        </li>
                    </ul>
                    <div class="px-4 py-8 border border-t-0 border-gray-150">
                        @foreach (range(5,0) as $value)
                            @if (isset($scores['comments'][$value]))
                                <div id="score-{{$value}}" x-show="openTab === {{ $value }}" class="space-y-4">
                                    @foreach ($scores['comments'][$value] as $comment)
                                        <div class="border-b border-gray-150 rounded-sm p-3">
                                            <div class="flex items-center space-x-3">
                                                <span class="text-xs font-semibold text-gray-500">Usuario: {{ $comment['user']}}</span>
                                                <span class="text-xxs md:text-xs font-medium text-gray-400">{{ $comment['date']}}</span>
                                                <span
                                                    class="text-xxs tracking-wide font-medium py-0.5 px-3 bg-gray-100 rounded-full text-gray-400 capitalize">
                                                    {{ Str::lower($comment['action']) }}
                                                </span>
                                            </div>
                                            <div class="mt-2">
                                                <p class="text-gray-600 text-sm md:text-base">{{ $comment['comment']}}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div id="score-{{$value}}" x-show="openTab === {{ $value }}">
                                    <p class="text-center text-xs md:text-sm font-medium">No hay comentarios para esta calificación</p>
                                </div>
                            @endif
                        @endforeach
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
