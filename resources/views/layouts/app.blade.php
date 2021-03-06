<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
        <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @stack('styles')
        <livewire:styles />

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body
    x-data="{ sidebarOpen: false }"
    class="m-0 font-sans text-sm antialiased text-gray-600 bg-white">
        <noscript>{{ __('You need to enable JavaScript to run this app.') }}</noscript>
        <livewire:offline/>
        <div class="flex h-screen overflow-hidden">
            <div class="lg:w-72">
                <div @click="sidebarOpen = !sidebarOpen" x-show="sidebarOpen" :class="{ 'opacity-100' : sidebarOpen }"
                class="fixed inset-0 z-40 transition-opacity duration-200 bg-black bg-opacity-25 opacity-0 lg:hidden lg:z-auto"
                aria-hidden="true"></div>
                @include('layouts.navigation')
            </div>

            <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
                <header style="background: #0a1410" class="sticky top-0 z-30 border-b border-gray-100 lg:hidden">
                    <div class="px-4 mx-auto lg:max-w-4xl xl:max-w-screen-lg 2xl:max-w-screen-xl sm:px-6 lg:px-4">
                        <div class="flex items-center justify-between h-16 -mb-px">
                            <div class="flex items-center">
                                <button class="text-gray-25 lg:hidden" aria-controls="sidebar" aria-expanded="false" @click="sidebarOpen = !sidebarOpen">
                                    <span class="sr-only">Mostrar menu</span>
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                </button>
                                <a class="inline-block ml-4 lg:hidden" href="/">
                                    <x-logo class="h-7"/>
                                </a>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="h-screen">
                    <div class="bg-gray-135">
                        <div class="items-end px-6 py-5 mx-auto lg:max-w-4xl xl:max-w-screen-lg 2xl:max-w-screen-xl xl:flex xl:space-x-16 2xl:space-x-36">

                            <div>
                                @isset($module)
                                    <span class="text-xs font-semibold text-gray-400">{{ $module }}</span>
                                @endisset

                                @isset($title)
                                    <h3 class="flex items-center my-1 text-base font-medium tracking-tight lg:text-xl">{{ $title }}</h3>
                                @endisset

                                @isset($description)
                                    <p class="text-xs font-light text-gray-500">{{ $description }}</p>
                                @endisset
                            </div>

                            @isset($actions)
                            <div class="flex-1 mt-5 xl:mt-0">
                                {{ $actions }}
                            </div>
                            @endisset

                        </div>
                    </div>
                    <div class="relative px-6 py-5 mx-auto sm:block lg:max-w-4xl xl:max-w-screen-lg 2xl:max-w-screen-xl">
                        @isset($scoresFilters)
                            <div>
                                {{ $scoresFilters }}
                            </div>
                        @endisset
                        <div class="pb-4">
                            {{ $slot}}
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <livewire:scripts />
        <script src="/vendor/livewire-charts/app.js"></script>
        @stack('scripts')
    </body>
</html>
