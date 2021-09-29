<div class="w-full mx-auto overflow-hidden">
    <div class="flex items-center mt-4">
        <div class="flex w-full md:w-2/5">
            <input
            wire:model.debounce.300ms="search"
            type="text"
            class="w-full p-2 text-xs border-gray-200 rounded-md focus:ring-gray-100 focus:border-gray-150"
            placeholder="Buscar usuarios...">
        </div>
        @can('can_create_new_permission')
        <button
            wire:click="createPermission"
            type="button"
            class="flex items-center flex-shrink-0 p-2 ml-auto text-xs font-bold leading-tight tracking-wide rounded-md bg-orange text-orange-lightest" >
            <x-heroicon-s-plus-circle class="w-3 h-3 md:w-4 md:h-4 md:mr-2"/>
            <span class="md:inline-block">
                Nuevo permiso
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
                                Permiso
                            </th>
                            @foreach($users as $user)
                            <th scope="col" class="sticky top-0 px-6 py-2 text-xs font-medium tracking-wider text-left text-gray-500 capitalize align-top bg-white border border-l-0 border-gray-200">
                                {{ $user['name'] }}
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permissions as $key => $permission)
                            @include('permission.users.item', ['permission' => $permission])
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div>
        <form wire:submit.prevent="savePermission">
            <x-modals.dialog maxWidth="sm" wire:model.defer="showModal">
                <x-slot name="title">Crear respuesta</x-slot>
                <x-slot name="content">
                    <div class="py-1">
                        <input
                        wire:model.lazy="permission.name"
                        class="w-full p-2 text-sm border-gray-100 rounded-md resize-none bg-gray-50 focus:ring-gray-200 focus:border-gray-100"
                        placeholder="Codigo del permiso"
                        id="name" />
                    </div>

                    <div class="py-1">
                        <input
                        wire:model.lazy="permission.description"
                        class="w-full p-2 text-sm border-gray-100 rounded-md resize-none bg-gray-50 focus:ring-gray-200 focus:border-gray-100"
                        placeholder="Descripción del permiso"
                        id="description" />
                    </div>

                </x-slot>
                <x-slot name="footer">
                    <button type="button" x-on:click="show=false" class="px-4 py-2 font-semibold text-gray-500 bg-gray-200 rounded-md">Cancelar</button>
                    <button type="submit" class="px-4 py-2 font-semibold rounded-md text-orange-light bg-orange">Guardar</button>
                </x-slot>
            </x-modals.dialog>
        </form>
    </div>
</div>
