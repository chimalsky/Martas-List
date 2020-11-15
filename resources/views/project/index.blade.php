@extends ('layouts.project')

@section ('content')
<section class="max-w-2xl mx-auto">
    <header class="mt-12 mx-auto">
        @include('project._nav')

        <h2 class="mt-4 text-gray-700 text-lg tracking-wide pl-2">
            Edited by Marta Werner<br/>
            and Caroline McCraw and Abraham Kim
        </h2>
    </header>
</section>

<section>
    <main class="block my-12 max-w-2xl flex flex-wrap justify-center mx-auto space-x-4">
        <img class="w-32 h-32 lg:w-48 lg:h-48 object-cover rounded-full" src="{{ asset('img/timeline.jpeg') }}" />
        <img class="w-32 h-32 lg:w-48 lg:h-48 object-cover rounded-full" src="{{ asset('img/birdring.jpg') }}" />
        <img class="w-32 h-32 lg:w-48 lg:h-48 object-cover rounded-full" src="{{ asset('img/map-ma.png') }}" />
    </main>
</section>

@endsection