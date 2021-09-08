@if($isMain)
    <ul class="mt-4">
    @foreach($menuGroup as $menu)
        @php $isActive = ( ($menu['route-group'] !== null && request()->route()->named($menu['route-group'] . '*')) || request()->routeIs($menu['route']) ) ? true : false @endphp
        @php $isOpen = ($menu['route-group'] !== null && request()->route()->named($menu['route-group'] . '*')) ? 'true' : 'false' @endphp

        <li @if(count($menu['submenu'])) x-data="{ isOpen: false }" @endif class="{{ ($isActive) ? 'bg-orange-lightest': '' }} rounded-md my-0.5 hover:bg-orange-lightest" >
            <a @click="isOpen = !isOpen" class="block px-2 py-2 text-gray-500 transition duration-150 cursor-pointer hover:text-gray-800" href="{{ ($menu['route']) ? route($menu['route']) : '#' }}">
                <div class="flex items-center justify-between">
                    <div class="flex items-center flex-grow">
                        @if($menu['icon'])
                            {{ svg($menu['icon'], ['class' => "w-5 h-5 mr-2 text-orange" ]) }}
                        @endif
                        <span class="text-xs font-semibold {{ ($isActive) ? 'text-orange': '' }}">{{ $menu['name'] }}</span>
                    </div>
                    @if(count($menu['submenu']))
                    <div class="flex flex-shrink-0 ml-2">
                        <x-heroicon-s-chevron-down x-show="!isOpen" class="flex-shrink-0 w-3 h-3 ml-1 text-gray-800 fill-current"/>
                        <x-heroicon-s-chevron-up x-show="isOpen" class="flex-shrink-0 w-3 h-3 ml-1 text-gray-800 fill-current"/>
                    </div>
                    @endif
                </div>
            </a>
            @if(count($menu['submenu']))
                @include('components.submenu', [ 'menuGroup' => $menu['submenu'], 'isMain' => false, 'ref' => $menu['id'] ])
            @endif
        </li>
    @endforeach
    </ul>
@else
    <div class="overflow-hidden"
    :class="{ 'max-h-0' : !isOpen }" x-ref="container{{$ref}}"
    x-bind:style="isOpen ? 'max-height: ' + $refs.container{{$ref}}.scrollHeight + 'px' : ''"
    >
        <ul class="pt-2 pb-2 pr-1 pl-7">
        @foreach($menuGroup as $menu)
            @php $isActive = ( request()->routeIs($menu['route']) ) ? true : false @endphp
            <li class="flex items-center mb-3">
                <a class="block transition duration-150 hover:font-semibold hover:text-gray-darker text-xs {{ ($isActive) ? 'font-semibold': 'font-medium' }}" href="{{ ($menu['route']) ? route($menu['route']) : '#' }}">
                    @if ($isActive)
                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-orange mr-1 -ml-3"></span>
                    @endif
                    <span>{{ $menu['name'] }}</span>
                </a>

            </li>
        @endforeach
        </ul>
    </div>
@endif
