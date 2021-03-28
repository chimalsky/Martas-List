@extends ('layouts.project')

@section ('content')
<section class="max-w-2xl mx-auto">
    <header class="mx-auto">
        @include('project._nav')

        <h2 class="mt-4 text-gray-700 text-lg tracking-wide pl-2">
            Curated by Marta Werner,<br/>
            Caroline McCraw, Abraham Kim, and Danielle Richards
        </h2>
    </header>
</section>

<section>
    <main class="block mt-12 mb-32 max-w-2xl flex flex-wrap justify-center mx-auto space-x-4">
        <img class="w-32 h-32 lg:w-48 lg:h-48 object-cover rounded-full" src="{{ asset('img/timeline.jpeg') }}" />
        <a href="@route('project.digital-objects.index')">
            <img class="w-32 h-32 lg:w-48 lg:h-48 object-cover rounded-full" src="{{ asset('img/birdring.jpg') }}" />
        </a>
        <img class="w-32 h-32 lg:w-48 lg:h-48 object-cover rounded-full" src="{{ asset('img/map-ma.png') }}" />
    </main>

    <footer class="block text-center max-w-3xl mx-auto text-gray-600 italic">
        <h1 class="mb-6 text-xl">
            Welcome!
        </h1>

        <p class="mb-4">
            Please be advised that this site is under active construction and has not officially launched.
            <br>
            Many changes are underway, often on a monthly basis. We’ll be posting periodic status updates.
        </p>

        <p class="mb-10">
            In the meantime, please enjoy watching our evolution and feel free to contact us with any questions or comments.
        </p>


        <div class="text-center text-sm">
            - Marta Werner, Caroline McCraw, Abe Kim
        </div>
    </footer>
</section>

@endsection