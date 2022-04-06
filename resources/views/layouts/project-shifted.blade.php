<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>
            @yield('title', "Dickinson's Birds")
        </title>

        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>

        <link rel="stylesheet" type="text/css" href="/css/trix.css">
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        <link href="/css/caroline-styles.css" rel="stylesheet">

        @stack('stylesheets')

        @livewireStyles

        <x-project.favicon />

        <script src="{{ mix('js/project/app.js') }}" defer="true"></script>
        
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Alegreya:ital,wght@0,400;1,500&family=Cormorant+SC&family=Cormorant+Upright:wght@300;400;500;600;700&display=swap" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Cormorant:ital,wght@0,300;0,400;0,600;0,700;1,400&display=swap&family=IM+Fell+Double+Pica&display=swap" rel="stylesheet">

        @stack('scripts')
    </head>
    <body data-controller="application @stack('stimulus-controllers')" id="body"
        @stack('stimulus-attributes') class="mt-8 px-2 flex flex-wrap loading" style="max-width: 2400px">
        <aside class="flex-shrink max-w-xs">
            <h1 class="text-xl -mb-3 tracking-wide flex">
                @include('project._nav')
            </h1>

            @yield('aside')

            <div class="pt-16 relative" style="max-width: 240px;">
                @yield('sticky-aside')
            </div>
        </aside>

        <main class="flex-1">
            <header class="">
                <!--
                <div class="flex justify-center space-x-4 max-w-xs mx-auto hidden">
                    <a href="@route('project.digital-objects.timeline')">
                        <img class="object-cover w-16 h-16 rounded-full" src="{{ asset('img/do-1.png') }}" />
                    </a>
                    <a href="@route('project.digital-objects.map')">
                        <img class="object-cover w-16 h-16 rounded-full" src="{{ asset('img/do-2.png') }}" />
                    </a>
                    <a href="@route('project.digital-objects.birdring')">
                        <img class="object-cover w-16 h-16 rounded-full" src="{{ asset('img/do-3.png') }}" />
                    </a>
                </div>
                -->

                <nav class="text-4xl text-center flex justify-center" style="font-family: Cormorant SC;">
                    @yield('header-anchor')
                </nav>

                <div class="text-center text-4xl block" style="font-family: Cormorant Upright; color:#806102;">
                    @yield('header-info')
                </div>
            </header>

            <main class="">
                <div class="mx-auto">
                    @yield('content')
                </div>
            </main>

            <footer class="pt-4 pb-12 mt-24 border-t-4 border-gray-300">
                @yield('footer')
                @include('project._footer')
            </footer>
        </main>

        @livewireScripts
    </body>
</html>
