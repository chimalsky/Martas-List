@extends ('layouts.project')

@section ('content')

<header class="mt-12">
    @include('project._nav')
</header>

<main class="mt-32 max-w-4xl mx-auto text-gray-700 text-lg">
    <header>
        <h1 class="text-4xl mb-4 text-center">
             {{ $poem->name }}
        </h1>

        <p class="mt-18 text-center">
            {{ $poem->meta->where('resource_attribute_id', 138)->first()->value ?? null }}
            {{ $poem->meta->where('resource_attribute_id', 131)->first()->value ?? null }}
        </p>
    </header>

    <section class="mt-12 flex flex-wrap">
        <div class="w-1/2">
            {!! $poem->meta->where('resource_attribute_id', 78)->first()->value ?? null !!}
        </div>

        <div class="w-1/2">
            @foreach ($poem->getMedia() as $medium)
                @if (Str::contains($medium->mime_type, 'image'))
                    <img class=" inline-block" src="{{ $medium->getUrl() }}" />
                @endif
            @endforeach
        </div>
    </section>
</main>

<footer class="text-center mt-32 text-sm">
    <p class="block">
        Funding and Support provided by Loyola University, Office of Research
    </p>

    <p class="block text-gray-600">
        Licensed under Creative Commons Attribution 4.0 International License, 2020
    </p>
</footer>

@endsection