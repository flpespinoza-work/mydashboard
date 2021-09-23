@php
    if($is_child) {
        if(isset($menu['submenu']) && count($menu['submenu']))
        {
            $class= "pl-3 font-medium text-gray-600 capitalize";
        }
        else
        {
            $class= "pl-6 font-normal text-gray-500 capitalize";
        }
    }
    else
    {
        $class = 'text-gray-800 uppercase';
    }
@endphp
<tr>
    <th
    class="sticky align-top left-0 px-2 z-20 text-left border-t-0 border border-gray-200 text-xs bg-gray-50 {{ $class }}">
        {{ $menu['name'] }}
    </th>
    @foreach ($roles as $role)
        <td class="text-center align-top border border-t-0 border-l-0 border-gray-100">
            <input type="checkbox"
            name="menu_rol[{{ $menu['id'] }}]"
            value="{{ $role['id'] }}"
            wire:click="$emitSelf('toggleMenuRole', {{ $role['id'] }}, {{ $menu['id'] }}, $event.target.checked)"
            class="border-gray-200 rounded appearance-none focus:ring-orange-light text-orange"
            {{in_array($role['id'], array_column($menuRoles[$menu["id"]], "id"))? "checked" : ""}}
            >
        </td>
    @endforeach
</tr>
@foreach ($menu['submenu'] as $key => $submenu)
    @include('menu.roles.item', ['menu' => $submenu, 'is_child' => true])
@endforeach
