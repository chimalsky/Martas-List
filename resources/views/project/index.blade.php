@extends ('layouts.project')

@section ('content')
<section class="max-w-4xl mx-auto mt-12">
    <header class="mx-auto">
        @include('project._nav')
    </header>
</section>

<section>
    <main class="block -mt-12 mb-32 max-w-4xl flex flex-wrap justify-center mx-auto gap-24">
        <img src="{{ asset('img/landing-page-static.png') }}" 
            alt="Dickinson's Birds project placeholder static image. Curated by Marta Werner, Abe Kim, Caroline McCraw, and Danielle Richards." />
    </main>
</section>

@endsection