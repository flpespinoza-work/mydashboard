<x-guest-layout>
    <div class="flex flex-col items-center justify-center px-10">
        <div name="logo">
            <a href="/">
                <x-logo-dark class="w-auto h-12" />
            </a>
        </div>
    </div>
    <div class="w-full max-w-sm mx-auto mt-4">
        <div class="mb-4 text-sm text-gray-600">
            Esta es un area protegida. Confirme su contraseña para poder ingresar
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="my-3">
                <label for="password" class="text-sm text-gray-600">Contraseña</label>
                <input
                type="password"
                id="password"
                name="password"
                class="w-full text-sm border-gray-300 rounded-md focus:border-gray-300 focus:ring-gray-200 p-2 block mt-2 {{ $errors->has('password') ? ' border-red' : '' }}"
                placeholder="******"/>
                @if($errors->has('password'))
                    <span class="text-red text-xs font-semibold mt-0.5">
                        {{ $errors->first('password') }}
                    </span>
                @endif
            </div>

            <div class="my-5">
                    <button type="submit" class="justify-center w-full h-10 text-sm capitalize rounded-md bg-orange text-gray-50 border-orange-light">Confirmar contraseña</button>
                </div>
        </form>
    </div>
</x-guest-layout>
