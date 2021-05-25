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
        @bukStyles(true)
        @livewireStyles

        <x-project.favicon />

        <script src="{{ mix('js/project/app.js') }}" defer="true"></script>

        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Alegreya:ital,wght@0,400;1,500&family=Cormorant+SC&family=Cormorant+Upright:wght@300;400;500;600;700&display=swap" rel="stylesheet"> 
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
           

            <main class="">
                <div class="mx-auto">
                    @yield('content')
                </div>
            </main>

        </main>

        <section class="">
            @yield('after-content-stretch')
        </section>

        <footer class="max-w-2xl mx-auto pt-4 pb-12 mt-24 border-t-4 border-gray-300">
            @yield('footer')
            @include('project._footer')
        </footer>

        @livewireScripts
        @bukScripts(true)
    </body>
</html>
