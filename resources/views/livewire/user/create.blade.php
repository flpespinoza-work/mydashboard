<div class="flex flex-col max-w-screen-md mt-4">
    <div class="pb-8 border-b border-gray-100">
        <h3 class="text-xs font-medium leading-6 text-gray-600 md:text-base">Datos del usuario</h3>
        <div class="items-center mt-2 space-y-2 md:flex md:space-y-0 md:space-x-2">
            <div class="md:w-3/5">
                <label for="name" class="block text-xs text-gray-600">Nombre</label>
                <input
                    id="name"
                    type="text"
                    wire:model="user.name"
                    class="w-full mt-2 text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200"
                >
            </div>
            <div class="md:w-2/5">
                <label for="email" class="block text-xs text-gray-600">Correo electrónico</label>
                <input
                    id="email"
                    type="email"
                    wire:model="user.email"
                    class="w-full mt-2 text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200"
                >
            </div>
        </div>
        <div class="items-center mt-2 space-y-2 md:flex md:space-y-0 md:space-x-2">
            <div class="md:w-1/2">
                <label for="phone" class="block text-xs text-gray-600">Teléfono</label>
                <input
                    id="phone"
                    type="text"
                    wire:model="user.phone_number"
                    class="w-full mt-2 text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200"
                >
            </div>
            <div class="md:w-1/2">
                <label for="password" class="block text-xs text-gray-600">Contraseña</label>
                <input
                    id="password"
                    type="password"
                    wire:model="user.password"
                    class="w-full mt-2 text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200"
                >
            </div>
        </div>
    </div>

    <div class="pb-8 mt-4 border-b border-gray-100">
        <h3 class="text-xs font-medium leading-6 text-gray-600 md:text-base">Información de la cuenta</h3>
        <div class="items-center mt-2 space-y-2 md:flex md:space-y-0 md:space-x-2">
            <div class="md:w-1/3">
                <label for="role" class="block text-xs text-gray-600">Rol de usuario</label>
                <select
                wire:model="role"
                id="role"
                class="{{ $errors->has('role') ? 'border-red-300 bg-red-50' : '' }} w-full text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200 mt-2">
                    <option value="">Seleccione un rol</option>
                    @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="md:w-1/3">
                <label for="home" class="block text-xs text-gray-600">Pagina de inicio</label>
                <select
                wire:model="user.home"
                id="home"
                class="{{ $errors->has('role') ? 'border-red-300 bg-red-50' : '' }} w-full text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200 mt-2">
                    <option value="" selected>Seleccione un rol</option>
                    @forelse ($modules as $module)
                        <option value="{{ $module->id }}">{{ $module->name }}</option>
                    @empty
                    @endforelse
                </select>
            </div>

            <div class="md:w-1/3">
                <label for="group" class="block text-xs text-gray-600">Grupo</label>
                <select
                wire:model="group"
                id="group"
                class="{{ $errors->has('group') ? 'border-red-300 bg-red-50' : '' }} w-full text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200 mt-2">
                    <option value="">Seleccione un grupo</option>
                    @foreach ($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
                </select>
            </div>

        </div>
    </div>

    <div class="pb-8 mt-4 border-b border-gray-100">
        <h3 class="text-xs font-medium leading-6 text-gray-600 md:text-base">Establecimientos</h3>
        <div class="mt-2">
            <label class="flex items-center">
                <input type="checkbox" id="allStores" class="border-gray-200 rounded appearance-none focus:ring-orange-light text-orange">
                <span class="ml-2 text-xs">Seleccionar todos</span>
            </label>
            <div class="flex flex-wrap items-center">
            </div>
        </div>
    </div>

</div>
