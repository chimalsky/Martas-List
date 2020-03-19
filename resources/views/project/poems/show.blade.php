@extends ('layouts.project')


@section ('header')
    @include('project._nav', ['title' => 'Poem Archive'])
@endsection

@section ('content')

<main class="max-w-4xl mx-auto text-gray-700 text-lg">
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
        <div class="w-1/3">
            {!! $poem->meta->where('resource_attribute_id', 78)->first()->value ?? null !!}
        </div>

        <div class="w-2/3">
            @livewire('project.media-viewer', $poem)
            
        </div>
    </section>
</main>
@endsection