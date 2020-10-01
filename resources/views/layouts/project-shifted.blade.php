<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>
            Dickinson's Birds
        </title>

        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>

        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        @stack('stylesheets')

        @livewireStyles

        <script src="{{ mix('js/app.js') }}" defer="true"></script>

        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Cormorant:ital,wght@0,300;0,400;0,600;0,700;1,400&display=swap&family=IM+Fell+Double+Pica&display=swap" rel="stylesheet"> 
        @stack('scripts')
    </head>
    <body data-controller="application" class="mt-8 px-2 flex flex-wrap" style="max-width: 1700px">
        <aside class="flex-shrink">
            <h1 class="text-xl -mb-3 tracking-wide flex">
                @include('project._nav')
            </h1>

            @yield('aside')

            <div class="sticky top-0 w-full pt-16">
                @yield('sticky-aside')
            </div>
        </aside>

        <main class="flex-1">
            <header class="">
                <div class="flex justify-center space-x-4 max-w-xs mx-auto">
                    <img class="object-cover w-16 h-16 rounded-full" src="{{ asset('img/do-1.jpg') }}" />
                    <img class="object-cover w-16 h-16 rounded-full" src="{{ asset('img/do-2.jpg') }}" />
                    <img class="object-cover w-16 h-16 rounded-full" src="{{ asset('img/do-3.png') }}" />
                </div>

                <nav class="text-2xl text-center flex justify-center font-serif mt-16">
                    @yield('header-anchor')
                </nav>

                <div class="text-center text-4xl font-hairline mb-8 block">
                    @yield('header-info')
                </div>
            </header>

            <main class="">
                <div class="mx-auto">
                    @yield('content')
                </div>
            </main>

            <footer class="pt-4 pb-12 border-t-4 border-gray-300">
                @yield('footer')

                <div class="text-lg">
                    <p class="mb-1">
                        Dickinson’s Birds: A Public Listening Project &#169; {{ carbon()->format('Y') }}
                    </p>
                    <p>
                        Edited by Marta Werner and Abraham Kim and Caroline McCraw
                    </p>
                </div>

                <div class="block mt-8">
                    <p class="block">
                        Funding and Support provided by Loyola University, Office of Research
                    </p>

                    <p class="block text-gray-600">
                        Licensed under Creative Commons Attribution 4.0 International License, 2020
                    </p>
                </div>
            </footer>
        </main>

        @livewireScripts
    </body>
</html>
