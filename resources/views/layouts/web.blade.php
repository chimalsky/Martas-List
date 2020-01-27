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

        @livewireAssets
        
        <script src="{{ mix('js/app.js') }}" defer="true"></script>
        @stack('scripts')
    </head>
    <body data-controller="application">
        <h1 class="hidden lg:block p-4 text-base text-gray-600 text-right"> 
            <span class="hidden">
                {{ Artisan::call('inspire') }} 
            </span>
            {{ Artisan::output() }}
        </h1>

        <section class="px-2">
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

        <footer class="web">
            <footer class="web-layouts">
            </footer>

            @yield('footer')

            <section class="event-log hidden
                bg-green-300 fixed bottom-0 right-0 p-4 w-full lg:max-w-md h-24">
            </section>
        </footer>
    </body>
</html>
