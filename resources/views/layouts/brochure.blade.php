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
        
        @stack('scripts')
    </head>
    <body data-controller="application">
        <header class="web py-2 border border-1 border-gray mb-12">
            <a href="{{ route('brochure.index') }}" class="font-light mx-2">
                Home 
            </a>   
            <a href="{{ route('resource-types.index') }}" class="font-light mx-2">
                Archiver 
            </a>   
            <a href="{{ route('dearchived.bird.show') }}" class="font-light mx-2">
                De-archived 
            </a>
            <a href="{{ route('blog.index') }}" class="font-light mx-2">
                Blog 
            </a>
        </header>

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
