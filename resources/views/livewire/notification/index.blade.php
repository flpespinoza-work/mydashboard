<div class="w-full mx-auto overflow-hidden">
    <div class="flex items-center py-3 bg-white rounded-md">
        <input class="flex-1 w-full max-w-lg text-sm border-gray-100 rounded bg-gray-50 focus:ring-gray-200 focus:border-gray-100"
        type="search"
        wire:model.debounce.500ms="search"
        id="search"
        placeholder="Buscar...">
        @can('can_create_new_campaign')
        <a
            href="{{ route('notifications.create') }}"
            class="flex items-center justify-center p-2 ml-2 transition duration-75 rounded-md md:ml-auto bg-orange">
            <x-icons.plus class="w-5 h-5 text-orange-light"/>
            <span class="hidden ml-2 text-xs font-semibold md:inline-block text-orange-light">Nueva campaña</span>
        </a>
        @endcan
    </div>
    <div class="mt-4">
        <div class="flex items-center space-x-4 text-xs">
            <div class="flex items-center space-x-1"><span class="block w-3 h-3 bg-green-400 rounded-full"></span><span>Enviada</span></div>
            <div class="flex items-center space-x-1"><span class="block w-3 h-3 bg-yellow-400 rounded-full"></span><span>En procesamiento</span></div>
            <div class="flex items-center space-x-1"><span class="block w-3 h-3 bg-red-400 rounded-full"></span><span>Suspendida</span></div>
        </div>
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden border-b border-gray-200">
                        <table class="min-w-full mt-6 divide-y divide-gray-200 table-auto">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                                        Campaña
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                                        Tipo
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                                        Estatus
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                                        Creación
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                                        Autor
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if ($campaigns->count() > 0)
                                    @forelse($campaigns as $campaign)
                                        @php $action = json_decode($campaign->notification->NOT_ACCION) @endphp
                                        <tr class="{{ $loop->even ? 'bg-gray-50' : '' }}">
                                            <td class="px-6 py-2 text-xs font-medium tracking-wider text-left text-gray-500">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 overflow-hidden rounded">
                                                        <a class="thumb" href="{{ $action->IMG }}">
                                                            <img loading="lazy" alt="imagen - {{ $campaign->CAMP_NOMBRE }}" class="w-10 h-10" src="{{ $action->IMG }}" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="font-medium text-gray-900 text-xxs">
                                                            {{ $campaign->CAMP_NOMBRE }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-2 font-medium tracking-wider text-left text-gray-500 ">
                                                <span class="{{ ($campaign->notification->NOT_TIPO == 'INFORMATIVA') ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }} text-xxs inline-block px-3 py-1 rounded-full">
                                                    {{ $campaign->notification->NOT_TIPO }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-2 font-medium tracking-wider text-center text-gray-500 text-xxs">
                                                @switch($campaign->CAMP_AUTORIZACION)
                                                    @case(1)
                                                        <span class="inline-block w-3 h-3 bg-green-400 rounded-full"></span>
                                                        @break
                                                    @case(2)
                                                        <span class="inline-block w-3 h-3 bg-yellow-400 rounded-full"></span>
                                                        @break
                                                    @default
                                                        <span class="inline-block w-3 h-3 bg-red-400 rounded-full"></span>
                                                @endswitch
                                            </td>
                                            <td class="px-6 py-2 font-medium tracking-wider text-left text-gray-500 text-xxs">{{ date('d/m/Y H:i:s', strtotime($campaign->CAMP_TS)) }}</td>
                                            <td class="px-6 py-2 font-medium tracking-wider text-left text-gray-500 text-xxs">{{ $campaign->CAMP_AUTOR }}</td>
                                            <td class="px-6 py-2 font-medium tracking-wider text-left text-gray-500 text-xxs">
                                                <div class="flex items-center space-x-2">
                                                    @can('can_see_campaign')
                                                    <a class="cursor-pointer" wire:click="stats('{{ Crypt::encrypt($campaign->CAMP_ID) }}', '{{ $campaign->CAMP_AUTORIZACION}}')">
                                                        <x-heroicon-o-trending-up class="w-5 h-5"/>
                                                    </a>
                                                    @endcan

                                                    @can('can_test-campaign')
                                                    <a href="">
                                                        <x-heroicon-s-check-circle class="w-5 h-5"/>
                                                    </a>
                                                    @endcan

                                                    @can('can_program_campaign')
                                                    <a class="cursor-pointer" wire:click="showProgram('{{ $campaign->CAMP_NOMBRE}}','{{ Crypt::encrypt($campaign->CAMP_ID) }}')">
                                                        <x-heroicon-s-clock class="w-5 h-5"/>
                                                    </a>
                                                    @endcan

                                                    @can('can_send_campaign')
                                                    <a href="">
                                                        <x-heroicon-s-chat-alt class="w-5 h-5"/>
                                                    </a>
                                                    @endcan

                                                    @can('can_suspend_campaign')
                                                    <a href="">
                                                        <x-heroicon-s-stop class="w-5 h-5 text-red-500"/>
                                                    </a>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="px-6 py-3 font-medium tracking-wider text-center text-gray-500 text-xxs">No hay campañas para mostrar</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-6">{!! $campaigns->links() !!}</div>
    </div>

    <div>
        <form wire:submit.prevent="program">
            <x-modals.dialog maxWidth="sm" wire:model.defer="showModal">
                <x-slot name="title">Programar campaña: @isset($program['name']) {{ $program['name'] }} @endisset</x-slot>
                <x-slot name="content">
                    <div class="relative py-4">
                        <h3 class="text-xs text-gray-500">Seleccione la fecha-hora de envío</h3>
                        <div class="relative mt-3">
                            <input
                            type="text"
                            id="date_range"
                            class="{{ $errors->has('program.datetime') ? 'border-red-300 bg-red-50' : '' }} w-full text-xs border-gray-200 rounded-sm focus:ring-gray-200 focus:border-gray-200">
                            <x-heroicon-o-calendar class="absolute right-0 w-5 h-5 mr-2 text-gray-400 transform -translate-y-1/2 top-1/2"/>
                        </div>
                    </div>
                </x-slot>
                <x-slot name="footer">
                    <button type="button" x-on:click="show=false" class="px-4 py-2 font-semibold text-gray-500 bg-gray-200 rounded-md">Cancelar</button>
                    <button type="submit" class="px-4 py-2 font-semibold rounded-md text-orange-light bg-orange">Programar</button>
                </x-slot>
            </x-modals.dialog>
        </form>
    </div>
</div>

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" integrity="sha512-+EoPw+Fiwh6eSeRK7zwIKG2MA8i3rV/DGa3tdttQGgWyatG/SkncT53KHQaS5Jh9MNOT3dmFL0FjTY08And/Cw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-minimal/minimal.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush

@push('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js" integrity="sha512-IsNh5E3eYy3tr/JiX2Yx4vsCujtkhwl7SLqgnwLNgf04Hrt9BT9SXlLlZlWx+OK4ndzAoALhsMNcCmkggjZB1w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('.thumb').magnificPopup({
            type: 'image'
        });

        $(function() {
            $('#date_range').daterangepicker({
                "singleDatePicker": true,
                "timePicker": true,
                "locale": {
                    "format": "DD/MM/YYYY  h:mm a",
                    "separator": " - ",
                    "applyLabel": "Seleccionar",
                    "cancelLabel": "Cancelar",
                    "fromLabel": "De",
                    "toLabel": "Hasta",
                    "customRangeLabel": "Custom",
                    "weekLabel": "W",
                    "daysOfWeek": [
                        "Dom",
                        "Lun",
                        "Mar",
                        "Mier",
                        "Jue",
                        "Vie",
                        "Sab"
                    ],
                    "monthNames": [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ],
                    "firstDay": 1,
                    "startDate": moment(),
                },
            });

            $('#date_range').on('apply.daterangepicker', function(ev, picker) {
                //console.log(picker.startDate.format('YYYY-MM-DD h:mm a'));
                @this.set('program.datetime', picker.startDate.format('YYYY-MM-DD h:mma'));
            });
        });

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

        window.addEventListener('swal:warning', event => {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 2000
            })

            Toast.fire({
                icon: 'warning',
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
