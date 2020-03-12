@extends ('layouts.project')

@section ('content')

<header class="mt-12">
    @include('project._nav')
</header>

<main class="mt-32 max-w-2xl mx-auto text-gray-700 text-lg">
    <section>
        <h1 class="text-4xl mb-4 font-serif">
            Poems 
        </h1>
    </section>

    <section class="mt-12 flex flex-col">

        @foreach ($poems as $poem)
            <article class="block mb-1 p-2 hover:bg-gray-200 cursor-pointer justify-between">
                <a href="@route('project.poems.show', $poem->id)">
                    @foreach ($poem->getMedia() as $medium)
                        @if (Str::contains($medium->mime_type, 'image'))
                            <img class="w-12 inline-block" src="{{ $medium->getUrl('thumb') }}" />
                        @endif
                    @endforeach

                    {{ $poem->meta->where('resource_attribute_id', 84)->first()->value ?? null }}
                </a>
            </article> 
        @endforeach
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