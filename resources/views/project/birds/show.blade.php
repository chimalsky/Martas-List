@extends ('layouts.project')


@section ('header')
    @include('project._nav', ['title' => 'Bird Archive', 'breadcrumb' => @route('project.birds.index')])
@endsection

@section ('before-content-stretch')
<header class="mb-8">
    <h1 class="text-4xl font-hairline text-center">
        {{ $bird->meta->where('resource_attribute_id', 55)->first()->value ?? null }}
        --
        {{ $bird->meta->where('resource_attribute_id', 56)->first()->value ?? null }}
    </h1>

    @if ($poems->count())
        <div class="block mt-2 text-center">
            <p>
                Mentioned in {{ $poems->count() }} 
                <a href="#poems">
                    @if ($poems->count() === 1)
                        Poem
                    @else 
                        Poems
                    @endif
                </a>
            </p>
        </div>
    @endif

    <section class="flex justify-center mt-6">
        @foreach ($bird->getMedia() as $sonogram)
            @if (Str::contains($sonogram->mime_type, 'image'))
                <img class="block" src="{{ $sonogram->getUrl() }}" />
            @endif
        @endforeach 
    </section>


    <section class="flex justify-center mt-2">
        @foreach ($bird->getMedia() as $audio)
            @if (Str::contains($audio->mime_type, 'audio'))
                <audio controls
                    src="{{ $audio->getUrl() }}">
                        Your browser does not support the
                        <code>audio</code> element.
                </audio>                    
            @endif
        @endforeach
    </section>
</header>
@endsection

@section('content')
<main class="max-w-4xl mx-auto text-gray-700 text-lg">
    <section class="text-center">
        <p class="text-2xl font-hairline">
            Habitat 
        </p>
        <p>
            <span>
                19thc. {{ $bird->meta->where('resource_attribute_id', 39)->first()->value ?? null }};
            </span>
            <span>
                21stc. {{ $bird->meta->where('resource_attribute_id', 40)->first()->value ?? null }}
            </span>
        </p>

        <p class="text-2xl font-hairline mt-6">
            Nest Type 
        </p>
        <p>
            {{ $bird->meta->where('resource_attribute_id', 42)->first()->value ?? null }}
        </p>

        <p class="text-2xl font-hairline mt-6">
            Seasons in Amherst, MA
        </p>
        <p>
            <span>
                19thc. {{ $bird->meta->where('resource_attribute_id', 43)->first()->value ?? null }};
            </span>
            <span>
                21stc. {{ $bird->meta->where('resource_attribute_id', 44)->first()->value ?? null }}
            </span>
        </p>
        <p>
            Migration Range:

            <a href="{{ $bird->meta->where('resource_attribute_id', 45)->first()->value ?? null }}"
                target="_blank"
                class="underline">
                link
            </a>
        </p>

        <p class="text-2xl font-hairline mt-6">
            Conservation Status
        </p>
        <p>
            <span>
                19thc. {{ $bird->meta->where('resource_attribute_id', 37)->first()->value ?? null }};
            </span>
            <span>
                21stc. {{ $bird->meta->where('resource_attribute_id', 38)->first()->value ?? null }}
            </span>
        </p>
    </section>


    <section id="poems" class="mt-12 lg:mt-24">
        <h1 class="text-2xl">
            Poems mentioning <span class="italic">{{ $bird->name }}</psan>
        </h1>
        
        <main class="mt-4 flex flex-wrap">
            @foreach ($poems as $poem)
                <article class="w-full lg:w-1/2 lg:px-2 pb-10 lg:pb-16">
                    @include('project.poems._single', $poem)
                </article>
            @endforeach
        </main>
    </section>

</main>
@endsection

@section('after-content-stretch')
<section class="flex justify-center my-12">
    @foreach ($bird->getMedia() as $sonogram)
        @if (Str::contains($sonogram->mime_type, 'image'))
            <img class="block" src="{{ $sonogram->getUrl() }}" />
        @endif
    @endforeach 
</section>
@endsection