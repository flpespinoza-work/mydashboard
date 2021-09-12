<div>
    <div class="flex flex-col w-full pb-10 space-y-4">
        <div class="flex items-center">
            <div class="w-full mr-2">
                <div class="flex items-center w-full space-x-2">
                    <div class="flex w-full md:w-2/5">
                        <span class="inline-flex items-center p-1 text-sm text-gray-400 border border-r-0 md:px-3 border-transparent0 rounded-l-md bg-gray-lightest">
                            <x-heroicon-s-search-circle class="w-5 h-5" />
                        </span>
                        <input
                        wire:model.debounce.300ms="search"
                        type="text"
                        class="w-full p-2 text-xs border-gray-200 rounded-sm md:p-3 focus:ring-gray-200 focus:border-gray-200"
                        placeholder="Buscar...">
                    </div>

                    <select wire:model="perPage"
                    class="inline-block p-2 text-xs leading-tight bg-white border border-gray-200 rounded-md appearance-none w-36 md:text-sm md:p-3 focus:outline-none focus:ring-0 focus:border-gray-300">
                        <option value="10"><span class="hidden md:inline">Mostrar</span> 10</option>
                        <option value="20"><span class="hidden md:inline">Mostrar</span> 20</option>
                        <option value="30"><span class="hidden md:inline">Mostrar</span> 30</option>
                        <option value="50"><span class="hidden md:inline">Mostrar</span> 50</option>
                    </select>
                </div>
            </div>
            <a href="{{ route('users.create') }}" class="flex items-center flex-shrink-0 p-2 ml-auto text-xs font-bold leading-tight tracking-wide bg-blue-500 rounded-md md:p-3 text-blue-50" >
                <x-heroicon-s-plus-circle class="w-4 h-4 md:w-5 md:h-5 md:mr-2"/>
                <span class="hidden md:inline-block">
                    Nuevo usuario
                </span>
            </a>
        </div>

        <div class="flex flex-col mt-10">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white border rounded-sm">
                  <table class="min-w-full divide-y divide-gray-light">
                    <thead>
                      <tr>
                        <x-table.heading value="Nombre"/>
                        <x-table.heading value="Role" class="hidden md:table-cell"/>
                        <x-table.heading value="Estado"/>
                        <x-table.heading value="Última sesión"/>
                        <x-table.heading />
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-light">
                      @forelse ($users as $user)
                      <tr class="cursor-pointer hover:bg-gray-lightest">
                        <x-table.cell>
                            <div class="flex items-center">
                                <div class="lg:ml-4">
                                <div class="text-sm font-medium text-gray-dark">
                                    {{ $user->name }}
                                </div>
                                <div class="text-gray text-xxs mt-0.5">
                                    {{ $user->email }}
                                </div>
                                <div class="mt-1 text-gray text-xxs">
                                    Tel: {{ $user->phone_number }}
                                </div>
                                </div>
                            </div>
                        </x-table.cell>
                        <x-table.cell class="hidden md:table-cell">
                            @foreach($user->roles as $key => $role)
                                <span class="inline-flex font-semibold leading-5 capitalize text-xxs text-gray">{{ $role->name }}</span>
                            @endforeach
                        </x-table.cell>
                        <x-table.cell>
                            @if(Cache::has('user-online-'. $user->id ))
                                <span class="inline-flex w-3 h-3 font-semibold leading-5 text-green-700 bg-green-300 rounded-full md:px-2 md:w-auto md:h-auto text-xxs">
                                    <span class="hidden md:inline-block">Conectado</span>
                                </span>
                            @else
                                <span class="inline-flex w-3 h-3 font-semibold leading-5 text-red-700 bg-red-300 rounded-full md:px-2 md:w-auto md:h-auto text-xxs">
                                    <span class="hidden md:inline-block">Desconectado</span>
                                </span>
                            @endif
                        </x-table.cell>
                        <x-table.cell>
                            <span class="inline-flex font-semibold leading-5 capitalize text-xxs text-gray">{{ $user->last_login_at }} </span>
                        </x-table.cell>
                        <x-table.cell>
                            <div class="flex items-center justify-end space-x-2 lg:space-x-4">
                                <a href="{{ route('users.show', $user) }}" class="text-gray-400 hover:text-gray-dark">
                                    <x-heroicon-s-eye class="w-5 h-5" />
                                </a>
                                <a href="{{ route('users.edit', $user) }}" class="text-gray-400 hover:text-gray-dark">
                                    <x-heroicon-s-pencil-alt class="w-5 h-5" />
                                </a>
                                <a href="#" wire:click="delete({{$user->id}})" class="text-gray-400 hover:text-red">
                                    <x-heroicon-s-trash class="w-5 h-5" />
                                </a>
                            </div>
                        </x-table.cell>
                      </tr>
                      @empty
                      <tr>
                        <td class="px-6 py-4 whitespace-nowrap" colspan="5">
                          <div class="flex items-center justify-center">
                              <span class="py-6 text-base text-gray">No hay usuarios registrados</span>
                          </div>
                        </td>
                      </tr>
                      @endforelse

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div>
            {!! $users->links() !!}
          </div>
    </div>
</div>

