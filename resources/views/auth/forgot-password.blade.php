<x-guest-layout>
    <div class="flex flex-col items-center justify-center px-10">
        <div>
            <a href="{{ route('login') }}">
                <x-logo-dark class="w-auto h-12"></x-logo>
            </a>
        </div>
        <div class="w-full max-w-sm mx-auto mt-4 text-sm text-gray-600">
            <p class="px-3">
            ¿Olvidó su contraseña? No hay problema. Simplemente déjenos saber su dirección de correo electrónico y le enviaremos un enlace para restablecer la contraseña que le permitirá elegir una nueva.
            </p>
        </div>
        <div class="w-full max-w-sm mx-auto mt-4">
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="my-3">
                    <label for="email" class="text-sm text-gray-600">Correo Electrónico</label>
                    <input
                    value="{{ old('email') }}"
                    type="email" id="email"
                    name="email"
                    class="w-full text-sm border-gray-300 rounded-md focus:border-gray-300 focus:ring-gray-200 p-2 block mt-2 {{ $errors->has('email') ? 'border-red' : '' }}" placeholder="example@email.com"/>
                    @if($errors->has('email'))
                        <span class="text-red text-xs font-semibold mt-0.5">
                            {{ $errors->first('email') }}
                        </span>
                    @endif
                </div>

                <div class="my-5">
                    <button type="submit" class="justify-center w-full h-10 text-sm rounded-md bg-orange text-gray-50 border-orange-light">Enviar link para restablecer contraseña</button>
                </div>

            </form>
        </div>
    </div>
</x-guest-layout>
