<div class="w-full mx-auto overflow-hidden">
    <div>
        <div id="containerFile" class="px-2 py-2 {{ $errors->has('file') ? 'bg-red-100' : 'bg-gray-100'}} rounded-md md:w-2/6 md:ml-auto">
            <form wire:submit.prevent="importStores" class="flex items-center">
                <label for="file" class="flex-1 inline-block cursor-pointer">
                    <span class="text-xs font-semibold {{ $errors->has('file') ? 'text-red-500' : 'text-gray-500'}}" x-ref="textfile">
                        @if (!is_null($this->file))
                            {{ $this->file->getClientOriginalName() }}
                        @else
                            Seleccionar archivo(.xlsx o .xsl)
                        @endif
                    </span>
                    <input class="hidden" id="file" name="file" type="file" wire:model="file" accept=".xlsx, .xls">
                </label>
                <button
                    type="submit"
                    class="px-4 py-2 text-xs font-semibold rounded-md bg-orange text-orange-lightest">
                    Importar
                </button>
            </form>
        </div>
    </div>

    <div class="flex items-center py-3 mt-5 space-x-3 bg-white rounded-md">
        <input class="flex-1 w-full text-sm border-gray-100 rounded-md bg-gray-50 focus:ring-gray-200 focus:border-gray-100" type="search" wire:model="search" id="search" placeholder="Buscar...">
        <button
            wire:click="create"
            class="flex items-center justify-center p-2 ml-auto transition duration-75 rounded-md bg-orange">
            <x-icons.plus class="w-5 h-5 text-orange-light"/>
            <span class="hidden ml-2 text-xs font-semibold md:inline-block text-orange-light">Nuevo establecimiento</span>
        </button>
        <a
            class="flex items-center justify-center p-2 ml-auto transition duration-75 rounded-md bg-gray-50"
            href="{{ route('groups.index') }}">
            <x-icons.group class="w-5 h-5 text-gray-500"/>
            <span class="hidden ml-2 text-xs font-semibold text-gray-500 md:inline-block">Volver a grupos</span>
        </a>
    </div>

    <div class="mt-4">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                                    Nombre
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                                    Grupo
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                                    Nodo Tokencash
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                                    Presupuesto
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                                    Giftcard
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($stores as $store)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">
                                            {{ $store->name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 text-xs font-semibold leading-5 text-blue-800 bg-blue-100 rounded-full">
                                            {{ $store->group->name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">
                                            {{ $store->node }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">
                                            {{ $store->budget }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">
                                            {{ $store->giftcard }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">No hay establecimientos registrados</td>
                                </tr>
                            @endforelse
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4">
            {!! $stores->links() !!}
        </div>
    </div>
    <div>
        <form wire:submit.prevent="saveStore">
            <x-modals.dialog wire:model.defer="showModal">
                <x-slot name="title">Crear nuevo establecimiento</x-slot>
                <x-slot name="content">
                    <div class="my-2">
                        <label class="block text-xs font-semibold text-gray-500" for="group">Grupo <span class="text-red-500">*</span></label>
                        <select wire:model.defer="group"
                        class="w-full mt-2 text-xs border-gray-100 rounded-md focus:ring-gray-200 focus:border-gray-100 bg-gray-50"
                        >
                            <option value="">Seleccione un grupo</option>
                            @foreach ($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                        @error('store.group_id')
                        <span class="font-medium text-red-400 text-xxs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="items-center md:space-x-2 md:flex">
                        <div class="my-2 md:w-2/3">
                            <label class="block text-xs font-semibold text-gray-500" for="name">Nombre del establecimiento <span class="text-red-500">*</span></label>
                            <input class="w-full mt-2 border-gray-100 rounded-md bg-gray-50 focus:ring-gray-200 focus:border-gray-100" wire:model.defer="store.name" type="text">
                            @error('store.name')
                            <span class="font-medium text-red-400 text-xxs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="my-2 md:w-1/3">
                            <label class="block text-xs font-semibold text-gray-500" for="node">Nodo Tokencash <span class="text-red-500">*</span></label>
                            <input class="w-full mt-2 border-gray-100 rounded-md bg-gray-50 focus:ring-gray-200 focus:border-gray-100" wire:model.defer="store.node" type="text">
                            @error('store.token_node')
                            <span class="font-medium text-red-400 text-xxs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="my-2 md:w-1/2">
                            <label class="block text-xs font-semibold text-gray-500" for="giftcard">Giftcard <span class="text-red-500">*</span></label>
                            <input class="w-full mt-2 border-gray-100 rounded-md bg-gray-50 focus:ring-gray-200 focus:border-gray-100" wire:model.defer="store.giftcard" type="text">
                            @error('store.token_giftcard')
                            <span class="font-medium text-red-400 text-xxs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="my-2 md:w-1/2">
                            <label class="block text-xs font-semibold text-gray-500" for="budget">Presupuesto <span class="text-red-500">*</span></label>
                            <input class="w-full mt-2 border-gray-100 rounded-md bg-gray-50 focus:ring-gray-200 focus:border-gray-100" wire:model.defer="store.budget" type="tel">
                            @error('store.token_budget')
                            <span class="font-medium text-red-400 text-xxs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="my-2">
                        <label class="block text-xs font-semibold text-gray-500" for="contact_name">Contacto</label>
                        <input class="w-full mt-2 border-gray-100 rounded-md bg-gray-50 focus:ring-gray-200 focus:border-gray-100" wire:model.defer="store.contact_name" type="text">
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="my-2 md:w-1/2">
                            <label class="block text-xs font-semibold text-gray-500" for="phone">Teléfono</label>
                            <input class="w-full mt-2 border-gray-100 rounded-md bg-gray-50 focus:ring-gray-200 focus:border-gray-100" wire:model.defer="store.phone" type="tel">
                            @error('store.phone')
                            <span class="font-medium text-red-400 text-xxs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="my-2 md:w-1/2">
                            <label class="block text-xs font-semibold text-gray-500" for="email">Correo electrónico</label>
                            <input class="w-full mt-2 border-gray-100 rounded-md bg-gray-50 focus:ring-gray-200 focus:border-gray-100" wire:model.defer="store.email" type="email">
                            @error('store.email')
                            <span class="font-medium text-red-400 text-xxs">{{ $message }}</span>
                            @enderror
                        </div>
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
            title: event.detail.message,
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
            title: event.detail.message,
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
