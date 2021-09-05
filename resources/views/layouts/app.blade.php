<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300,400,500,600,700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">


        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <livewire:styles />

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body
    x-data="{ sidebarOpen: false }"
    class="m-0 font-sans text-sm antialiased text-gray-700 bg-gray-50">
        <noscript>{{ __('You need to enable JavaScript to run this app.') }}</noscript>
        <div class="flex h-screen overflow-hidden">
            <div class="lg:w-72">
                <div x-show="sidebarOpen" :class="{ 'opacity-100' : sidebarOpen }"
                class="fixed inset-0 z-40 transition-opacity duration-200 bg-black bg-opacity-25 opacity-0 pointer-events-none lg:hidden lg:z-auto"
                aria-hidden="true"></div>
                @include('layouts.navigation')
            </div>

            <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
                <header class="sticky top-0 z-30 bg-white border-b border-gray-100 lg:hidden">
                    <div class="px-4 mx-auto lg:max-w-4xl xl:max-w-screen-lg 2xl:max-w-screen-xl sm:px-6 lg:px-4">
                        <div class="flex items-center justify-between h-16 -mb-px">
                            <div class="flex items-center">
                                <button class="text-gray-darker lg:hidden" aria-controls="sidebar" aria-expanded="false" @click="sidebarOpen = !sidebarOpen">
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
                    <div class="w-full">
                        <div class="p-6 mx-auto lg:max-w-4xl xl:max-w-screen-lg 2xl:max-w-screen-2xl">
                            <span class="text-xs font-normal text-gray-700">{{ $sectionTitle}}</span>
                            <h3 class="flex items-center mt-2 font-medium tracking-tight text-md lg:text-xl">{{ $title }}</h3>
                            <p class="mt-2 text-xs font-medium text-gray-500 md:font-semibold">{{ $description }}</p>
                        </div>
                    </div>
                    <div class="relative p-6 mx-auto lg:py-6 lg:max-w-4xl xl:max-w-screen-lg 2xl:max-w-screen-2xl">
                        <div class="lg:pb-4">
                            {{ $slot}}
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <livewire:scripts />
    </body>
</html>
