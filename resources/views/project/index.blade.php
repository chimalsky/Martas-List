@extends ('layouts.project')

@section ('content')
<section class="container mx-auto">
    <header class="mt-12 mx-auto">
        @include('project._nav')

        <h2 class="mt-4 text-gray-700 text-lg tracking-wide pl-2">
            Edited by Marta Werner<br/>
            and Caroline McCraw and Abraham Kim
        </h2>
    </header>
</section>

<section>
    <main class="block my-12 container flex flex-wrap mx-auto">
        <img class="w-full md:w-1/2 lg:w-1/3 object-cover" src="{{ asset('img/timeline.jpeg') }}" />
        <img class="w-full md:w-1/2 lg:w-1/3 object-cover" src="{{ asset('img/birdring.jpg') }}" />
        <img class="w-full md:w-1/2 lg:w-1/3 object-cover" src="{{ asset('img/map-ma.png') }}" />
    </main>
</section>

@endsection