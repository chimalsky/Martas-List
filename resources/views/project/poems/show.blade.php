@extends ('layouts.project')


@section ('header')
    @include('project._nav', ['title' => 'Poem Archive', 'breadcrumb' => @route('project.poems.index')])
@endsection

@section ('content')

<main class="max-w-4xl mx-auto text-gray-700 text-lg">
    <header class="text-center">
        <h1 class="text-4xl font-hairline mb-8">
             {{ $firstline }}
        </h1>

        <p class="mt-18 text-black text-lg">
            {{ $season }} {{ $year }}
        </p>

        <p class="text-base text-gray-600">
            {{ $state }}
            <br/>
            {{ $setting }}, {{ $circulation }}
        </p>

        <p class="mt-2 text-gray-600">

            Copied in 
            {{ $poem->meta->where('resource_attribute_id', 142)->first()->value ?? null }}
            on 
            {{ $poem->meta->where('resource_attribute_id', 87)->first()->value ?? null }},
            bound into
            {{ $poem->meta->where('resource_attribute_id', 3)->first()->value ?? null }}
        </p>

        @if ($birds->count())
            <div class="block mt-4">
                <p>
                    Mentions {{ $birds->count() }} 
                    <a href="#birds">
                        @if ($birds->count() === 1)
                            Bird
                        @else 
                            Birds
                        @endif
                    </a>
                </p>
            </div>
        @endif
    </header>

    <section class="mt-12 flex flex-wrap">
        <div class="w-1/3 mt-16">
            {!! $poem->meta->where('resource_attribute_id', 78)->first()->value ?? null !!}
        </div>

            <div class="w-2/3 md:pl-4 lg:pl-8">
                @if ($poem->media()->exists())
                    @livewire('project.media-viewer', ['resource' => $poem])
                @endif
            </div>
        </section>

        <section id="birds" class="mt-12 lg:mt-24">
            <h1 class="text-2xl">
                Birds in <span class="italic">{{ $poem->name }}</psan>
            </h1>
            
            <main class="mt-4 flex flex-wrap">
            @foreach ($birds as $bird)
                <article class="w-full lg:w-1/2 lg:px-2 pb-10 lg:pb-16">
                    @include('project.birds._single', $bird)
                </article>
            @endforeach
        </main>
    </section>
</main>
@endsection