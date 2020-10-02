@extends ('layouts.project')


@section ('header')
    @include('project.birds._header')
@endsection

@section ('before-content-stretch')
<header class="mb-8 ml-48">
    <h1 class="text-4xl font-hairline text-center">
        {{ $bird->firstMetaByAttribute(500)->value ?? null }}
        <span class="italic">
            ({{ $bird->firstMetaByAttribute(501)->value ?? null }})
        </span>

        | 

        <span class="italic">
            Affiliated Manuscripts
        </span>

        | 

        <a href="@route('project.birds.data', $bird)">
            Further Data
        </a>
    </h1>

    <header class="my-10 text-center">
        <a href="@route('resources.edit', $bird)" target="_blank" class="text-xl font-mono border border-black p-2">
            View/Edit Data
        </a>
    </header>

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

@php
    $nineteenthBird = $bird->resources->firstWhere('resource_type_id', 8);
    $twentyfirstBird = $bird->resources->firstWhere('resource_type_id', 15);

    $migrationMapLink = $bird->firstMetaByAttribute(506)
@endphp


@if ($bird->category)
<main class="relative hidden xl:block ml-48">
    <img src="{{ asset('img/bird-notebook.png') }}" />
    <section class="absolute inset-0 flex flex-wrap py-32 pl-24 pr-48 pl-64">
        <div class="w-1/2 pr-20">
            <header class="text-xl">
                <span class="text-3xl">O</span>CCURENCE IN 
                <span class="text-3xl">A</span>MHERST <br/>
                & <span class="text-3xl">C</span>ONNECTICUT 
                <span class="text-3xl">V</span>ALLEY, <span class="text-3xl">M</span>ASS.
            </header>

            <main class="mt-6 text-lg">
                @if ($nineteenthBird)
                    @php
                        $presence = $nineteenthBird->firstMetaByAttribute(538);
                    @endphp

                    @if ($presence)
                        @php
                            $presence = collect(explode(',', $presence->value));
                            $presence = $presence->map(function($month) { return (int) $month; });

                            $arrival = date("F", mktime(0, 0, 0, $presence->first(), 1));
                            $departure = date("F", mktime(0, 0, 0, $presence->last(), 1));
                        @endphp 
                        
                        <div class="text-lg">
                            <span class="font-bold">19th c.-</span> {{ $arrival }} - {{ $departure }}
                        </div>
                    @endif
                @endif

                @if ($twentyfirstBird)
                    @php
                        $presence = $twentyfirstBird->firstMetaByAttribute(574);
                    @endphp

                    @if ($presence)
                        @php
                            $presence = collect(explode(',', $presence->value));
                            $presence = $presence->map(function($month) { return (int) $month; });

                            $arrival = date("F", mktime(0, 0, 0, $presence->first(), 1));
                            $departure = date("F", mktime(0, 0, 0, $presence->last(), 1));
                        @endphp 
                        
                        <div class="text-lg">
                            <span class="font-bold">21st c.-</span> {{ $arrival }} - {{ $departure }}
                        </div>
                    @endif
                @endif
            </main>

            <header class="text-xl mt-16 mb-6">
                <span class="text-3xl">H</span>ABITAT
            </header>
            <main class="pl-6 italic text-lg">
                {{ optional($bird->firstMetaByATtribute(504))->value }}
            </main>

            <header class="text-xl mt-16 mb-6">
                <span class="text-3xl">N</span>EST
                <span class="text-3xl">M</span>ATERIAL
            </header>
            <main class="pl-6 italic text-lg">
                {{ $bird->firstMetaByAttribute(505)->value ?? null }}
            </main>
        </div>


        <div class="w-1/2 px-8">
            @php 
                $fieldNotes = $nineteenthBird  
                    ? $nineteenthBird->firstMetaByAttribute(590)
                    : null;
            @endphp

            <header class="text-xl mb-6">
                <span class="text-3xl">C</span>ONSERVATION
                <span class="text-3xl">S</span>TATUS
            </header>
            <main class="pl-6 italic text-lg">
                <p>
                    19thc. {{ $bird->meta->where('resource_attribute_id', 37)->first()->value ?? null }};
                </p>
                <p>
                    21stc. {{ $bird->meta->where('resource_attribute_id', 38)->first()->value ?? null }}
                </p>
            </main>

            @if ($fieldNotes)
                <header class="text-xl mt-16 mb-6">
                    <span class="text-3xl">F</span>IELD
                    <span class="text-3xl">N</span>OTES
                </header>
                <main class="pl-6 italic text-lg">
                    {{ $fieldNotes->value }}
                    <p class="text-right">
                        —H.L. Clark, 1887
                    </p>
                </main>
            @endif

            <header class="text-xl mt-16 mb-6">
                <span class="text-3xl">S</span>IGNIFICANT
                <span class="text-3xl">E</span>NVIRONMENTAL
                <span class="text-3xl">T</span>HREATS
            </header>
            <main class="pl-6 italic text-lg">
                {{ $bird->firstMetaByAttribute(510)->value ?? null }}
            </main>

            @if ($migrationMapLink)
                <header class="text-xl mt-16">
                    <span class="text-3xl">M</span>IGRATION
                    <span class="text-3xl">R</span>ANGE
                    <span class="text-3xl">M</span>AP
                </header>
                <main class="pl-6 italic text-lg">
                    <a href="{{ $migrationMapLink }}">
                        {{ $migrationMapLink }}
                    </a>
                </main>
            @endif
        </div>
    </section>
</main>
@endif

<main class="block ml-48">
    <section class="text-center">
        <p class="text-2xl font-hairline">
            Habitat 
        </p>
        <p>
            {{ optional($bird->firstMetaByATtribute(504))->value ?? 'Unknown' }}
        </p>

        <p class="text-2xl font-hairline mt-6">
            Nest Material 
        </p>
        <p>
            {{ $bird->firstMetaByAttribute(505)->value ?? null }}
        </p>

        <p class="text-2xl font-hairline mt-6">
            Seasons in Amherst, MA
        </p>
        <div class="mb-4">
            @if ($nineteenthBird)
                @php
                    $presence = $nineteenthBird->firstMetaByAttribute(538);
                @endphp

                @if ($presence)
                    @php
                        $presence = collect(explode(',', $presence->value));
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
                @endif
            @endif
        </div>

        <div class="mb-4">
            @if ($twentyfirstBird)
                @php
                    $presence = $twentyfirstBird->firstMetaByAttribute(574);
                @endphp

                @if ($presence)
                    @php
                        $presence = collect(explode(',', $presence->value));
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
                @endif
            @endif
        </div>
        

        @if($migrationMapLink)
        <p class="">
            Migration Range: 

            <a href="{{ $bird->firstMetaByAttribute(506)->value }}"
                target="_blank"
                class="underline">
                link
            </a>
        </p>
        @endif

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