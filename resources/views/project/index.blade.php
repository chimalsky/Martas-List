@extends ('layouts.project')

@section ('content')
<section class="max-w-2xl mx-auto">
    <header class="mx-auto">
        @include('project._nav')

        <h2 class="mt-4 text-gray-700 text-lg tracking-wide pl-2">
            Curated by Marta Werner, Caroline McCraw, Danielle <br>
            Richards, and Will Sikich
        </h2>
    </header>
</section>

<section>
    <main class="block my-24 max-w-2xl flex flex-wrap justify-center mx-auto space-x-16">
        <a href="@route('project.digital-objects.timeline')">
            <img class="w-32 h-32 object-cover rounded-full" src="{{ asset('img/do-1.png') }}" />
        </a>
        <a href="@route('project.digital-objects.map')">
            <img class="w-32 h-32 object-cover rounded-full" src="{{ asset('img/do-2.png') }}" />
        </a>
        <a href="@route('project.digital-objects.birdring')">
            <img class="w-32 h-32 object-cover rounded-full" src="{{ asset('img/do-3.png') }}" />
        </a>
    </main>

    <footer class="block text-center max-w-3xl mx-auto text-gray-600 italic">
    </footer>
</section>

@endsection