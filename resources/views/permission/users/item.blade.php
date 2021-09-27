<tr>
    <th
    class="sticky left-0 z-20 px-2 text-xs text-left align-top border border-t-0 border-gray-200 bg-gray-50">
        {{ $permission['description'] }}
    </th>
    @foreach ($users as $user)
        <td class="text-center align-top border border-t-0 border-l-0 border-gray-100">
            <input type="checkbox"
            name="user_permission[{{ $permission['id'] }}]"
            value="{{ $user['id'] }}"
            wire:click="$emitSelf('toggleUserPermission', {{ $user['id'] }}, {{ $permission['id'] }}, $event.target.checked)"
            class="border-gray-200 rounded appearance-none focus:ring-orange-light text-orange"
            {{in_array($permission['id'], array_column($userPermissions[$user["id"]], "id")) ? "checked" : ""}}
            >
        </td>
    @endforeach
</tr>
