<div
    x-data="{ showStoreList: @entangle('showStores'), showType: null, 'campaign': { } }"
    class="mt-7">
    <div class="md:flex md:space-x-8">
        <div class="md:w-8/12">
            <h5 class="text-xs font-semibold text-gray-500 sm:text-sm">Nueva campaña push</h5>
            <form wire:submit.prevent="saveCampaign" class="mt-4">
                <div class="pb-6">
                    <h3 class="text-xs font-medium leading-6 text-gray-600 md:text-base">Datos generales de la campaña</h3>
                    <div class="items-center mt-4 space-y-2 md:flex md:space-y-0 md:space-x-2">
                        <div class="relative md:w-3/5">
                            <label for="type" class="block text-xs text-gray-600">Establecimiento <span class="text-xs text-red-400">*</span></label>
                            <div class="relative w-full mt-2">
                                <input
                                x-on:click="showStoreList = true"
                                x-ref="search"
                                wire:model="selectedStore"
                                placeholder="Seleccione un establecimiento"
                                type="text"
                                class="{{ $errors->has('filters.store') ? 'border-red-300 bg-red-50' : '' }} w-full text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200">
                                @if (!$selectedStore)
                                    <x-heroicon-s-chevron-down x-on:click="showStoreList = true" class="absolute right-0 w-5 h-5 mr-2 text-gray-400 transform -translate-y-1/2 top-1/2"/>
                                @else
                                    <span class="absolute right-0 inline-block transform -translate-y-1/2 top-1/2" x-on:click="$refs.search.focus()" wire:click="clearStore">
                                        <x-heroicon-s-x class="w-5 h-5 mr-2 text-gray-400"/>
                                    </span>
                                @endif

                            </div>
                            <div x-show="showStoreList" @click.away="showStoreList = false" class="absolute z-50 w-full p-2 mt-1 overflow-y-auto bg-white border border-gray-200 max-h-72">
                                @forelse ($stores as $id => $store)
                                    <button
                                        type="button"
                                        wire:click="selectStore({{$id}}, '{{trim($store)}}')"
                                        class="inline-block w-full px-1 py-2 text-xs text-left hover:bg-gray-100 focus:bg-gray-100 focus:outline-none focus:ring-0">{{ trim($store) }}</button>
                                @empty
                                    <button type="button" class="inline-block w-full px-1 py-2 text-xs text-left hover:bg-gray-100">No se encontraron establecimientos</button>
                                @endforelse
                            </div>
                        </div>

                        <div class="md:w-2/5">
                            <label for="type" class="block text-xs text-gray-600">Tipo <span class="text-xs text-red-400">*</span></label>
                            <select wire:model.lazy="filters.type"
                                id="type"
                                x-on:change="showType = $event.target.value"
                                class="w-full mt-2 text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200">
                                <option value="" selected>Seleccione un tipo...</option>
                                <option value="INFORMATIVA">INFORMATIVA</option>
                                <option value="CANJE_CUPON">CANJE DE CUPON</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="pb-6">
                    <h3 class="text-xs font-medium leading-6 text-gray-600 md:text-base">Información de la campaña</h3>
                    <div class="items-center mt-2 space-y-2 md:flex md:space-y-0 md:space-x-2">
                        <div class="md:w-1/2">
                            <label for="name" class="block text-xs text-gray-600">Nombre <span class="text-xs text-red-400">*</span></label>
                            <input
                                id="name"
                                type="text"
                                wire:model.lazy="filters.name"
                                class="w-full mt-2 text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200"
                            >
                        </div>
                        <div class="md:w-1/2">
                            <label for="header" class="block text-xs text-gray-600">Encabezado <span class="text-xs text-red-400">*</span></label>
                            <input
                                id="header"
                                type="text"
                                wire:model.lazy="filters.header"
                                x-model="campaign.header"
                                class="w-full mt-2 text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200"
                            >
                        </div>
                    </div>
                    <div class="mt-4" wire:ignore>
                        <label for="body" class="block text-xs text-gray-600">Cuerpo de la notificación <span class="text-xs text-red-400">*</span></label>
                        <div
                        class="h-64"
                        x-ref="quillEditor"
                        x-model="campaign.body"
                        x-init="
                            quill = new Quill($refs.quillEditor, {theme: 'snow'});
                            quill.on('text-change', () => { campaign.body = quill.root.innerHTML; @this.set('filters.body', quill.root.innerHTML) })
                        "
                        >
                        </div>
                    </div>

                    <div class="mt-4" x-show="showType === 'INFORMATIVA'">
                        <label class="block text-xs text-gray-600">Imagen <span class="text-xs">(Campañas informativas)</span></label>
                        <label for="file" class="flex flex-1 p-2 mt-2 border border-gray-200 rounded cursor-pointer bg-gray-50">
                            <x-heroicon-s-photograph class="w-4 h-4"/>
                            <span class="text-xs ml-2 font-semibold {{ $errors->has('file') ? 'text-red-500' : 'text-gray-500'}}">
                                @if (!is_null($file))
                                    {{ $file->getClientOriginalName() }}
                                @else
                                    Seleccionar archivo(.png o .jpg)
                                @endif
                            </span>
                            <input class="hidden" id="file" name="file" type="file" wire:model="file" accept=".png, .jpg">
                        </label>
                    </div>

                    <div class="mt-4" x-show="showType === 'CANJE_CUPON'">
                        <label for="coupon" class="block text-xs text-gray-600">Código del cupón <span class="text-xs">(Campañas de inducción)</span></label>
                        <input
                                id="coupon"
                                type="text"
                                wire:model.lazy="filters.coupon"
                                class="w-full mt-2 text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200"
                            >
                    </div>
                </div>

                <div class="pb-6">
                    <h3 class="text-xs font-medium leading-6 text-gray-600 md:text-base">Filtros de la campaña (Opcionales)</h3>
                    <div class="items-center mt-4 space-y-2 md:flex md:space-y-0 md:space-x-2">
                        <div class="relative md:w-3/5">
                            <label class="block text-xs text-gray-600">Sexo</label>
                            <div class="flex items-center mt-3 space-x-3">
                                <label for="femenino" class="text-xs">
                                    <input type="radio" class="text-orange focus:ring-orange" wire:model.lazy="filters.gender" id="femenino" value="femenino">
                                    Femenino
                                </label>
                                <label for="masculino" class="text-xs">
                                    <input type="radio" class="text-orange focus:ring-orange" wire:model.lazy="filters.gender" id="masculino" value="masculino">
                                    Masculino
                                </label>
                                <label for="otros" class="text-xs">
                                    <input type="radio" class="text-orange focus:ring-orange" wire:model.lazy="filters.gender" id="otros" value="otros">
                                    Otros
                                </label>

                            </div>
                        </div>

                        <div class="md:w-2/5">
                            <label for="activity" class="block text-xs text-gray-600">Tiempo sin actividad <span class="text-xs">*</span></label>
                            <input
                                id="activity"
                                type="text"
                                wire:model.lazy="filters.activity"
                                class="w-full mt-2 text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200"
                            >
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <button
                        type="submit"
                        class="flex items-center justify-center p-2 ml-2 transition duration-75 rounded-md md:ml-auto bg-orange">
                        <x-icons.plus class="w-5 h-5 text-orange-light"/>
                        <span class="hidden ml-2 text-xs font-semibold md:inline-block text-orange-lightest">Guardar campaña</span>
                    </button>
                </div>
            </form>
        </div>

        <div class="px-4 md:px-8 md:w-4/12">
            <h5 class="text-xs font-semibold text-gray-500 sm:text-sm">Previa</h5>
            <div style="min-height:330px;" class="max-h-full px-5 py-6 mt-6 border border-gray-200 rounded-lg bg-gray-50">
                <div class="flex flex-col min-h-full px-4 py-2 space-y-6 tracking-wide bg-white border border-gray-100">
                    <p class="text-sm font-extrabold text-gray-800 md:text-xl" style="font-family:Arial, sans-serif;" x-text="campaign.header ? campaign.header : 'Título de la notificación'"></p>
                    <div class="w-full overflow-hidden">
                        @if($file)
                        <img src="{{ $file->temporaryUrl() }}" alt="">
                        @else
                        <img src="{{ asset('img/placeholder-image.jpg')}}" class="w-full h-auto" alt="">
                        @endif
                    </div>
                    <p class="text-sm text-gray-500" x-html="campaign.body ? campaign.body : 'Contenido de la notificación'"></p>
                </div>

            </div>
        </div>

    </div>
</div>

@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
.ql-toolbar.ql-snow {
    border: 1px solid #e5e7eb;
    margin-top: 0.5rem;
}

.ql-container.ql-snow {
    border: 1px solid #e5e7eb;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
@endpush
