@extends ('layouts.project')

@section ('content')
<section class="container mx-auto">
    <header class="mt-12 max-w-2xl mx-auto">
        @include('project._nav')

        <h2 class="mt-4 text-gray-700 text-lg tracking-wide pl-2">
            Edited by Marta Werner<br/>
            and Abraham Kim and Caroline McCraw
        </h2>
    </header>
</section>

<section>
    <main class="block my-12 max-w-2xl mx-auto">
        <img src="{{ asset('img/map-ma.png') }}" />
    </main>
</section>

@endsection