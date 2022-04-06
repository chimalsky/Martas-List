@extends ('layouts.project')

@section ('content')
<section class="max-w-6xl mx-auto">
    <header class="mx-auto">
        @include('project._nav')

        <h2 class="mt-4 text-gray-700 text-lg tracking-wide pl-2">
            Curated by Marta Werner, Caroline McCraw, Danielle Richards, and Will Sikich
        </h2>
    </header>
</section>

<section>
    <main class="block mt-24 mb-32 max-w-4xl flex flex-wrap justify-center mx-auto gap-32">
        <a href="@route('project.digital-objects.timeline')">
            <img class="w-48 h-48 object-cover rounded-full" src="{{ asset('img/do-1.png') }}" />
        </a>
        <a href="@route('project.digital-objects.map')">
            <img class="w-48 h-48 object-cover rounded-full" src="{{ asset('img/do-2.png') }}" />
        </a>
        <a href="@route('project.digital-objects.birdring')">
            <img class="w-48 h-48 object-cover rounded-full" src="{{ asset('img/do-3.png') }}" />
        </a>
    </main>
</section>

@endsection