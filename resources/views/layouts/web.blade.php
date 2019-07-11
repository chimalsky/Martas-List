<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>
            {{ config('app.name') }}
        </title>

        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        @stack('stylesheets')
        
        <script src="{{ mix('js/app.js') }}" defer="true"></script>
        @stack('scripts')
    </head>
    <body data-controller="application">
        <h1 class="w-full p-4 text-base text-gray-600 text-right"> 
            <span class="hidden">
                {{ Artisan::call('inspire') }} 
            </span>
            {{ Artisan::output() }}
        </h1>

        @yield('header')

        <main class="web container mx-auto">
            @if (session('status'))
                <div class="bg-green-200 p-8 text-center">
                    {{ session('status') }}
                </div>
            @endif
           
            @yield('content')
        </main>

        <footer class="web">
            <footer class="web-layouts">
            </footer>

            @yield('footer')
        </footer>
    </body>
</html>
