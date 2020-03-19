@extends ('layouts.project')


@section ('header')
    @include('project._nav', ['title' => 'Bird Archive'])
@endsection

@section ('content')

<main class="max-w-4xl mx-auto text-gray-700 text-lg">
    <header>
        <h1 class="text-4xl mb-4 text-center">
            {{ $bird->meta->where('resource_attribute_id', 55)->first()->value ?? null }}
            --
            {{ $bird->meta->where('resource_attribute_id', 56)->first()->value ?? null }}
        </h1>

        @foreach ($bird->getMedia() as $sonogram)
            @if (Str::contains($sonogram->mime_type, 'image'))
                <img class="block" src="{{ $sonogram->getUrl() }}" />
            @endif
        @endforeach 

    </header>
</main>
@endsection