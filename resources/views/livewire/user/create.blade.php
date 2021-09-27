<div
    x-data="newUser()"
    class="flex flex-col max-w-screen-lg mt-4">
    <form wire:submit.prevent="createUser">
        <div class="pb-8 border-b border-gray-100">
            <h3 class="text-xs font-medium leading-6 text-gray-600 md:text-base">Datos del usuario</h3>
            <div class="items-center mt-2 space-y-2 md:flex md:space-y-0 md:space-x-2">
                <div class="md:w-3/5">
                    <label for="name" class="block text-xs text-gray-600">Nombre <span class="text-xs text-red-400">*</span></label>
                    <input
                        id="name"
                        type="text"
                        wire:model="user.name"
                        class="w-full mt-2 text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200"
                    >
                </div>
                <div class="md:w-2/5">
                    <label for="email" class="block text-xs text-gray-600">Correo electrónico <span class="text-xs text-red-400">*</span></label>
                    <input
                        id="email"
                        type="email"
                        wire:model="user.email"
                        class="w-full mt-2 text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200"
                    >
                </div>
            </div>
            <div class="items-center mt-2 space-y-2 md:flex md:space-y-0 md:space-x-2">
                <div class="md:w-1/3">
                    <label for="phone" class="block text-xs text-gray-600">Teléfono</label>
                    <input
                        id="phone"
                        type="text"
                        maxlength="10"
                        wire:model="user.phone_number"
                        class="w-full mt-2 text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200"
                    >
                </div>
                <div class="md:w-1/3">
                    <label for="password" class="block text-xs text-gray-600">Contraseña <span class="text-xs text-red-400">* mínimo 8 caracteres</span></label>
                    <input
                        id="password"
                        type="password"
                        wire:model="user.password"
                        class="w-full mt-2 text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200"
                    >
                </div>
                <div class="md:w-1/3">
                    <label for="password_confirmation" class="block text-xs text-gray-600">Confirmar contraseña <span class="text-xs text-red-400">*</span></label>
                    <input
                        id="password_confirmation"
                        type="password"
                        wire:model="user.password_confirmation"
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
                            <option value="{{ $module->route }}">{{ $module->description }}</option>
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
                @if (count($stores))
                    <label class="flex items-center w-full pb-2">
                        <input
                            x-on:click="selectAll($event)"
                            type="checkbox" id="allStores"
                            class="border-gray-200 rounded appearance-none focus:ring-orange-light text-orange">
                        <span class="ml-2 text-xs">Seleccionar todos</span>
                    </label>
                @endif

                <div class="grid grid-cols-3 gap-4 mt-5">
                    @forelse ($stores as $store)
                        <div>
                            <label class="flex items-center w-full">
                                <input
                                    type="checkbox"
                                    id="{{ $store->id }}"
                                    wire:model="userStores"
                                    value="{{ $store->id }}"
                                    class="border-gray-200 rounded appearance-none focus:ring-orange-light text-orange store">
                                <span class="ml-2 text-xs">{{ $store->name }}</span>
                            </label>
                        </div>
                    @empty
                        <p class="col-span-3">
                            Sin establecimientos para asignar, seleccione un grupo
                        </p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="pb-8 mt-8">
            <p class="text-xs italic">Los datos marcados con <span class="text-xs text-red-400">*</span> son obligatorios</p>
            <button type="submit" class="block w-full py-2 ml-auto text-xs font-semibold text-white border rounded-md md:w-72 border-orange-light bg-orange">Guardar usuario</button>
        </div>
    </form>
</div>


@push('styles')
    <link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-minimal/minimal.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endpush

@push('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let file = document.querySelector('#file').files[0];
</script>
<script>
    window.addEventListener('swal:success', event => {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        })

        Toast.fire({
            icon: 'success',
            title: 'Éxito',
            text: event.detail.message,
            showClass: {
                popup: 'animate__animated animate__backInRight'
            },
            hideClass: {
                popup: 'animate__animated animate__backOutRight'
            }
        })
    });

    window.addEventListener('swal:error', event => {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            showConfirmButton: false,
            timer: 2000
        })

        Toast.fire({
            icon: 'error',
            title: 'Error',
            text: event.detail.message,
            showClass: {
                popup: 'animate__animated animate__backInRight'
            },
            hideClass: {
                popup: 'animate__animated animate__backOutRight'
            }
        })
    });
</script>
@endpush
