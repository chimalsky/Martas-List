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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/mark.js/8.11.1/mark.min.js" defer="true"></script>

        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Cormorant:ital,wght@0,300;0,400;0,600;0,700;1,400&display=swap&family=IM+Fell+Double+Pica&display=swap" rel="stylesheet"> 
        @stack('scripts')
    </head>
    <body data-controller="application">
        <section class="px-2 py-4 mb-12 mx-auto" style="max-width: 1700px">
            @yield('header')
        </section>

        <section class="">
            @yield('before-content-stretch')
        </section>

        <main class="web mx-auto mb-24 px-2" style="max-width: 1700px">
            @if (session('status'))
                <div class="bg-green-200 p-8 text-center">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-200 p-2 my-2">
                    <h1 class="font-bold">
                        Uh oh!
                    </h1>
                    
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
           
            @yield('content')
        </main>

        <section class="">
            @yield('after-content-stretch')
        </section>

        <footer class="container mx-auto pt-4 pb-12 border-t-4 border-gray-300">
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

        @livewireScripts
    </body>
</html>
