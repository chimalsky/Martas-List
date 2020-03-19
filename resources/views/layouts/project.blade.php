<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>
            Dickinson's Birds
        </title>

        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        @stack('stylesheets')

        @livewireAssets
        
        <script src="{{ mix('js/app.js') }}" defer="true"></script>
        @stack('scripts')
    </head>
    <body data-controller="application">
        <section class="px-2 py-4 mb-12">
            @yield('header')
        </section>

        <main class="web container mx-auto mb-24 px-2">
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

        <footer class="container mx-auto pt-4 pb-12 border-t-2 border-gray-400">
            @yield('footer')

            <div class="text-lg">
                <p class="mb-1">
                    Dickinson’s Birds: A Public Listening Project &#169; {{ carbon()->format('Y') }}
                </p>
                <p>
                    Edited by Marta Werner, with Abraham Kim and Caroline McCraw
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
    </body>
</html>
