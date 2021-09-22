<div class="w-full mx-auto overflow-hidden">
    <div>
        <div id="containerFile" class="px-2 py-2 {{ $errors->has('file') ? 'bg-red-50' : 'bg-gray-100'}} rounded-md md:w-2/6 md:ml-auto">
            <form wire:submit.prevent="importStores" class="flex items-center">
                <label for="file" class="flex-1 inline-block cursor-pointer">
                    <svg class="inline-block w-4 h-4" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 512 512" fill="currentColor"><path d="M453.546814,273.4485474h-81.4267578l0.000061-40.7133179h81.4266968V273.4485474z M453.546814,296.7133179h-81.4266968l-0.000061,40.7133789h81.4267578V296.7133179z M453.546814,104.7789307h-81.4266968l-0.000061,40.7133789h81.4267578V104.7789307z M453.546814,168.7570801h-81.4266968l-0.000061,40.7133789h81.4267578V168.7570801z M453.546814,360.6914673h-81.4266968l-0.000061,40.7133789h81.4267578V360.6914673z M509.7894897,440.9549561c-2.3264771,12.0977173-16.8670044,12.3884888-26.5800171,12.7956543h-180.883606v52.3457031h-36.1185913L0,459.5667725V52.491333L267.7775879,5.9036255h34.5482178v46.3553734L476.986084,52.258667c9.8294067,0.4071655,20.647522-0.2907715,29.1973267,5.5835571C512.1740723,66.4501953,511.5928345,77.3846436,512,87.2722168l-0.2330322,302.7910767C511.4761353,406.9884033,513.3373413,424.2625122,509.7894897,440.9549561z M213.2798462,349.6988525c-16.0526733-32.5706787-32.3961792-64.9087524-48.3907471-97.4794312c15.8200684-31.6982422,31.4074707-63.5128174,46.9367065-95.3273926c-13.2027588,0.6397705-26.4055176,1.4540405-39.5501099,2.3846436c-9.8293457,23.9046021-21.2872925,47.1693726-28.9646606,71.8881836c-7.1539307-23.322937-16.6343384-45.7734375-25.300415-68.5147705c-12.7956543,0.697937-25.5912476,1.4540405-38.3869019,2.210144c13.4935913,29.7789307,27.8595581,59.1506958,40.9459839,89.104126c-15.4129028,29.0809326-29.8370361,58.5690308-44.784668,87.8245239c12.7374268,0.5234375,25.4749146,1.046875,38.2124023,1.2213745c9.0732422-23.1484375,20.3566895-45.4244995,28.2666626-69.038208c7.0957642,25.3585815,19.1353149,48.7978516,29.0228271,73.0513916C185.3039551,348.012207,199.2628174,348.8846436,213.2798462,349.6988525z M484.2601929,79.8817749H302.3258057l-0.000061,24.8971558h46.529541v40.7133789h-46.529541v23.2647705h46.529541v40.7133789h-46.529541v23.2647705h46.529541v40.7133179h-46.529541v23.2647705h46.529541v40.7133789h-46.529541v23.2647705h46.529541v40.7133789h-46.529541v26.8971558h181.9344482V79.8817749z"></path></svg>
                    <span class="text-xs font-semibold {{ $errors->has('file') ? 'text-red-500' : 'text-gray-500'}}">
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
                    {{ $errors->has('file') ? 'disabled' : ''}}
                    class="px-4 py-2 text-xs font-semibold rounded-md bg-orange text-orange-lightest">
                    Importar
                </button>
            </form>
        </div>
    </div>

    <div class="flex items-center py-3 mt-5 space-y-2 bg-white rounded-md md:space-y-0 md:space-x-3">
        <input class="flex-1 text-sm border-gray-100 rounded-md bg-gray-50 focus:ring-gray-200 focus:border-gray-100" type="search" wire:model="search" id="search" placeholder="Buscar...">
        <select
        wire:model="filterGroup"
        class="p-2 text-xs font-semibold border border-gray-100 rounded-md md:w-64 focus:ring-gray-200 focus:border-gray-100 bg-gray-50"
        >
            <option value="">Todos los grupos...</option>
            @foreach ($groups as $group)
            <option value="{{ $group->id }}">{{ $group->name }}</option>
            @endforeach
        </select>
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
