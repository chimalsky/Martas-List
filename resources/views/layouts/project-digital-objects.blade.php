<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>
            @yield('title', "Dickinson's Birds")
        </title>

        <link rel="stylesheet" type="text/css" href="/css/trix.css">
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        <link href="/css/caroline-styles.css" rel="stylesheet">

        @stack('stylesheets')

        @livewireStyles

        <x-project.favicon />

        <script src="{{ mix('js/project/app.js') }}" defer="true"></script>
        
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Alegreya:ital,wght@0,400;1,500&family=Cormorant+SC&family=Cormorant+Upright:wght@300;400;500;600;700&display=swap&family=Alegreya+SC&display=swap" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Cormorant:ital,wght@0,300;0,400;0,600;0,700;1,400&display=swap&family=IM+Fell+Double+Pica&display=swap" rel="stylesheet">
        @stack('scripts')
    </head>
    <body data-controller="application @stack('stimulus-controllers')" id="body"
        @stack('stimulus-attributes') class="mt-8 px-2 flex flex-wrap loading" style="max-width: 2400px">
        
        </header>
        <main class="flex-1">
            <span x-data="{ open: false }" @keydown.window.escape="open = false" @click.away="open = false" class="relative inline-block text-left">
                <span class="flex-1 flex justify-between space-x-2">
                    <a href="/">
                        <img src="{{ asset('img/bird-icon.png') }}" class="h-12 w-12 mb-1" />
                    </a>
                    <button @click="open = !open" type="button" id="menu-toggle"
                    class="h-10 w-10 ml-1 border border-transparent p-1 hover:border-gray-700">
                        <img src="{{ asset('img/hamburger.png') }}" />
                        <h2 style="font-family: Josefin Sans; letter-spacing: 2.5px; color: #806f68;" class="text-sm uppercase mt-2">
                            Under construction
                        </h2>
                    </button>
                </span>
                <span x-show="open" 
                    x-transition:enter="transition ease-out duration-300" 
                    x-transition:enter-start="transform opacity-0 scale-95" 
                    x-transition:enter-end="transform opacity-100 scale-100" 
                    x-transition:leave="transition ease-in duration-300" 
                    x-transition:leave-start="transform opacity-100 scale-100" 
                    x-transition:leave-end="transform opacity-0 scale-95" 
                    class="origin-top-left absolute left-0 rounded-md shadow-2xl flex-1 z-50"
                    style="width: 16rem; display: none">
                    <div class="rounded-md bg-white shadow-xs">
                    <div class="py-1 text-base">
                        @include('project._nav-items')
                    </div>
                    </div>
                </span>
            </span>
            <main class="">
                <header>
                    @yield('header-info')
                </header>
                <div class="mx-auto">
                    @yield('content')
                </div>
            </main>

            <footer class="pt-4 pb-12 mt-24 border-t border-gray-600">
                @yield('footer')
                @include('project._footer')
            </footer>
        </main>

        @livewireScripts
    </body>
</html>
