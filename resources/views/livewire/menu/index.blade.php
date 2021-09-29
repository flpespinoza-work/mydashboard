<div class="w-full mx-auto overflow-hidden">
    <div class="flex items-center mt-4 space-x-2 overflow-x-auto md:justify-end">
        @can('can_create_new_menu')
            <button
                wire:click="createMenu('section')"
                type="button"
                class="flex items-center flex-shrink-0 p-2 text-xs font-bold leading-tight tracking-wide rounded-md md:w-auto bg-orange text-orange-lightest" >
                <x-heroicon-s-plus-circle class="w-3 h-3 md:w-4 md:h-4 md:mr-2"/>
                <span class="md:inline-block">
                    Nueva sección
                </span>
            </button>
            <button
                wire:click="createMenu('group')"
                type="button"
                class="flex items-center flex-shrink-0 p-2 text-xs font-bold leading-tight tracking-wide rounded-md bg-orange text-orange-lightest" >
                <x-heroicon-s-plus-circle class="w-3 h-3 md:w-4 md:h-4 md:mr-2"/>
                <span class="md:inline-block">
                    Nuevo grupo/modulo
                </span>
            </button>
            <button
                wire:click="createMenu('item')"
                type="button"
                class="flex items-center flex-shrink-0 p-2 text-xs font-bold leading-tight tracking-wide rounded-md bg-orange text-orange-lightest" >
                <x-heroicon-s-plus-circle class="w-3 h-3 md:w-4 md:h-4 md:mr-2"/>
                <span class="md:inline-block">
                    Nuevo item
                </span>
            </button>
        @endcan
    </div>

    <div class="flex flex-col mt-6">
        <div class="overflow-x-auto">
            <div class="relative z-10 max-h-screen overflow-auto bg-white">
                <table style="border-spacing:0;" class="w-full border-separate table-auto min-w-max">
                    <thead class="border border-gray-200 bg-gray-50">
                        <tr>
                            <th scope="col" class="sticky top-0 left-0 z-20 px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 align-top bg-white border border-gray-200">
                                Menu
                            </th>
                            @foreach($roles as $role)
                            <th scope="col" class="sticky top-0 px-6 py-2 text-xs font-medium tracking-wider text-center text-gray-500 align-top bg-white border border-l-0 border-gray-200">
                                {{ $role['name'] }}
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($menus as $key => $menu)
                            @if ($menu["menu_id"] != null)
                                @break
                            @endif
                            @include('menu.roles.item', ['menu' => $menu, 'is_child' => false])
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div>
        <form wire:submit.prevent="saveMenu('{{$type}}')">
            <x-modals.dialog maxWidth="md" wire:model.defer="showModal">
                @if($type == "section")
                    <x-slot name="title">Crear nueva sección</x-slot>
                    <x-slot name="content">
                        <div class="py-1">
                            <label for="name" class="block text-xs text-gray-600">Nombre de la sección</label>
                            <input
                                wire:model.lazy="menu.name"
                                id="name"
                                type="text"
                                class="w-full mt-2 text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200"
                            >
                        </div>
                        <div class="py-1">
                            <label for="order" class="block text-xs text-gray-600">Orden</label>
                            <input
                                wire:model.lazy="menu.order"
                                id="order"
                                type="number"
                                class="w-full mt-2 text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200"
                            >
                        </div>
                    </x-slot>
                @elseif ($type == "group")
                    <x-slot name="title">Crear nuevo grupo</x-slot>
                    <x-slot name="content">
                        <div class="py-1">
                            <label for="section" class="block text-xs text-gray-600">Sección</label>
                            <select
                                wire:model="selectedSection"
                                id="section"
                                class="w-full mt-2 text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200">
                                <option value="" selected>Sección...</option>
                                @if(!empty($menuSection))
                                    @foreach ($menuSection as $id => $section)
                                        <option value="{{ $id }}">{{ $section }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="py-1">
                            <label for="group_name" class="block text-xs text-gray-600">Nombre del grupo</label>
                            <input
                                wire:model.lazy="menu.route-group"
                                id="group_name"
                                type="text"
                                class="w-full mt-2 text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200"
                            >
                        </div>
                        <div class="py-1">
                            <label for="name" class="block text-xs text-gray-600">Nombre</label>
                            <input
                                wire:model.lazy="menu.name"
                                id="name"
                                type="text"
                                class="w-full mt-2 text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200"
                            >
                        </div>
                        <div class="py-1">
                            <label for="description" class="block text-xs text-gray-600">Descripcion</label>
                            <input
                                wire:model.lazy="menu.description"
                                id="description"
                                type="text"
                                class="w-full mt-2 text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200"
                            >
                        </div>
                        <div class="py-1">
                            <label for="route" class="block text-xs text-gray-600">Ruta</label>
                            <input
                                wire:model.lazy="menu.route"
                                id="route"
                                type="text"
                                class="w-full mt-2 text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200"
                            >
                        </div>
                        <div class="flex items-center space-x-1">
                            <div class="w-1/2 py-1">
                                <label for="order" class="block text-xs text-gray-600">Orden</label>
                                <input
                                    wire:model.lazy="menu.order"
                                    id="order"
                                    type="number"
                                    class="w-full mt-2 text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200"
                                >
                            </div>
                            <div class="w-1/2 py-1">
                                <label for="icon" class="block text-xs text-gray-600">Icono</label>
                                <input
                                    wire:model.lazy="menu.icon"
                                    id="icon"
                                    type="text"
                                    placeholder="heroicon-s-icon"
                                    class="w-full mt-2 text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200"
                                >
                            </div>
                        </div>
                    </x-slot>
                @else
                    <x-slot name="title">Crear elemento de un grupo</x-slot>
                    <x-slot name="content">
                        <div class="items-center md:flex md:space-x-1">
                            <div class="py-1 md:w-1/2">
                                <label for="section" class="block text-xs text-gray-600">Sección</label>
                                <select
                                    wire:model="selectedSection"
                                    id="section"
                                    class="w-full mt-2 text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200">
                                    <option value="" selected>Sección...</option>
                                    @if(!empty($menuSection))
                                        @foreach ($menuSection as $id => $section)
                                            <option value="{{ $id }}">{{ $section }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="py-1 md:w-1/2">
                                <label for="group" class="block text-xs text-gray-600">Grupo</label>
                                <select
                                    wire:model.lazy="menu.menu_id"
                                    id="group"
                                    class="w-full mt-2 text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200">
                                    <option value="" selected>Grupo de menu...</option>
                                    @if(!empty($menuGroup))
                                        @foreach ($menuGroup as $id => $group)
                                            <option value="{{ $id }}">{{ $group }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="py-1">
                            <label for="group_name" class="block text-xs text-gray-600">Nombre del grupo</label>
                            <input
                                wire:model.lazy="menu.route-group"
                                id="group_name"
                                type="text"
                                class="w-full mt-2 text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200"
                            >
                        </div>
                        <div class="py-1">
                            <label for="name" class="block text-xs text-gray-600">Nombre</label>
                            <input
                                wire:model.lazy="menu.name"
                                id="name"
                                type="text"
                                class="w-full mt-2 text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200"
                            >
                        </div>
                        <div class="py-1">
                            <label for="description" class="block text-xs text-gray-600">Descripcion</label>
                            <input
                                wire:model.lazy="menu.description"
                                id="description"
                                type="text"
                                class="w-full mt-2 text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200"
                            >
                        </div>

                        <div class="flex items-center space-x-1">
                            <div class="w-1/2 py-1">
                                <label for="route" class="block text-xs text-gray-600">Ruta</label>
                                <input
                                    wire:model.lazy="menu.route"
                                    id="route"
                                    type="text"
                                    class="w-full mt-2 text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200"
                                >
                            </div>
                            <div class="w-1/2 py-1">
                                <label for="order" class="block text-xs text-gray-600">Orden</label>
                                <input
                                    wire:model.lazy="menu.order"
                                    id="order"
                                    type="number"
                                    class="w-full mt-2 text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200"
                                >
                            </div>
                        </div>
                    </x-slot>
                @endif
                <x-slot name="footer">
                    <button type="button" x-on:click="show=false" class="px-4 py-2 font-semibold text-gray-500 bg-gray-200 rounded-md">Cancelar</button>
                    <button type="submit" class="px-4 py-2 font-semibold rounded-md text-orange-light bg-orange">Guardar</button>
                </x-slot>
            </x-modals.dialog>
        </form>
    </div>
</div>

