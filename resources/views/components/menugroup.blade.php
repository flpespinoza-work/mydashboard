<div class="px-6 py-4 mt-3">
    <h3 class="pl-1 text-xs font-light text-gray-400 capitalize">{{ $menuGroup['name'] }}</h3>
    @if( count($menuGroup['submenu']) )
        @include('components.submenu', [ 'menuGroup' => $menuGroup['submenu'], 'isMain' => true ])
    @endif
</div>
