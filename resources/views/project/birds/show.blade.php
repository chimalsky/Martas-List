@extends ('layouts.project')


@section ('header')
    @include('project._nav', ['title' => 'Bird Archive', 'breadcrumb' => @route('project.birds.index')])
@endsection

@section ('before-content-stretch')
<header class="mb-8">
    <h1 class="text-4xl font-hairline text-center">
        {{ $bird->firstMetaByAttribute(500)->value ?? null }}
        --
        {{ $bird->firstMetaByAttribute(501)->value ?? null }}
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

    @php 
        $xc_citation = $bird->metaByAttribute(502)->first()->value;
        $url = Str::afterLast($xc_citation, ' ');
        $url = Str::beforeLast($url, '.');
        $url = 'https://'.trim($url);
    @endphp

    <section class="flex justify-center mt-6 hidden">
    </section>


    <section class="flex justify-center mt-2">
        <iframe src='{{ $url }}/embed' scrolling='no' frameborder='0' width='340' height='220'></iframe>
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
            {{ $bird->firstMetaByATtribute(504)->value }}
        </p>

        <p class="text-2xl font-hairline mt-6">
            Nest Type 
        </p>
        <p>
            {{ $bird->firstMetaByAttribute(505)->value ?? null }}
        </p>

        <p class="text-2xl font-hairline mt-6">
            Seasons in Amherst, MA
        </p>
        <div class="mb-4">
            @php
                $nineteenthBird = $bird->resources->firstWhere('resource_type_id', 8);
                $presence = $nineteenthBird->firstMetaByAttribute(538)->value;
                $presence = collect(explode(',', $presence));
                $presence = $presence->map(function($month) { return (int) $month; });

                $arrival = date("F", mktime(0, 0, 0, $presence->first(), 1));
                $departure = date("F", mktime(0, 0, 0, $presence->last(), 1));
            @endphp 
            <header class="font-bold">
                19thc.
            </header>
            <span>
                 {{ $arrival }}
            </span> --- 
            <span>
                {{ $departure }}
            </span>
        </div>

        <div class="mb-4">
            @php
                $twentyfirstBird = $bird->resources->firstWhere('resource_type_id', 15);
                $presence = $twentyfirstBird->firstMetaByAttribute(574)->value;
                $presence = collect(explode(',', $presence));
                $presence = $presence->map(function($month) { return (int) $month; });

                $arrival = date("F", mktime(0, 0, 0, $presence->first(), 1));
                $departure = date("F", mktime(0, 0, 0, $presence->last(), 1));
            @endphp 
            <header class="font-bold">
                21stc.
            </header> 
            <span>
                {{ $arrival }} 
            </span> --- 
            <span>
                {{ $departure }}
            </span>
        </div>

        <p class="">
            Migration Range: 

            <a href="{{ $bird->firstMetaByAttribute(506)->value }}"
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