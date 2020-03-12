@extends ('layouts.project')

@section ('content')

<header class="mt-12">
    <h1 class="font-serif text-4xl text-yellow-700 -mb-3 tracking-wide flex items-center">
        @include('project._nav')

        <span class="ml-2">
            Dickinson's Birds
        </span>
    </h1>
    <h1 class="font-serif text-4xl tracking-wide">
        A Public Listening Project 
    </h1>

    <h2 class="mt-4 text-gray-700 text-lg tracking-wide">
        Edited by Marta Werner, with Abraham Kim and Caroline McCraw
    </h2>
</header>

<footer class="text-center mt-32 text-sm">
    <p class="block">
        Funding and Support provided by Loyola University, Office of Research
    </p>

    <p class="block text-gray-600">
        Licensed under Creative Commons Attribution 4.0 International License, 2020
    </p>
</footer>

@endsection