@extends ('layouts.project-shifted')

@section('header-anchor')
<a href="@route('project.birds.index')" class=''>
    <div>
        <span class="text-4xl">B</span>IRD 

        <span class="text-4xl">A</span>RCHIVE
    </div>
</a>
@endsection 


@section ('header-info')
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

        <a href="@route('project.bird.poems', $bird)" class="italic">
            Affiliated Manuscripts
        </a>

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
    <section class="absolute inset-0 flex flex-wrap py-32 pr-48 pl-48">
        <div class="w-2/5 pr-18 overflow-auto" style="max-height: 80%;">
            <x-project.bird.notebook.entry header="Occurence in Amhrest Connecticut & Valley Mass.">
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
            </x-project.bird.notebook.entry>

            <x-project.bird.notebook.entry header="Habitat" :data="$bird->firstMetaByAttribute(504)" />

            <x-project.bird.notebook.entry header="Nest Material" :data="$bird->firstMetaByAttribute(505)" />
        </div>


        <div class="w-3/5 pl-32 pr-8 overflow-auto" style="max-height: 80%;">
            <x-project.bird.notebook.entry header="Conservation Status" :data="$bird->firstMetaByAttribute(37)">
                <p>
                    19thc. -- {{ optional($bird->firstMetaByAttribute(507))->value ?? 'Information Coming Soon' }};
                </p>
                <p>
                    21stc. -- {{ optional($bird->firstMetaByAttribute(509))->value ?? 'Information Coming Soon' }}
                </p>
            </x-project.bird.notebook.entry>

            @php 
                $fieldNotes = $nineteenthBird  
                    ? $nineteenthBird->firstMetaByAttribute(590)
                    : null;
            @endphp
            @if ($fieldNotes)
            <x-project.bird.notebook.entry header="Field Notes" :data="$fieldNotes">
                <p class="text-right">
                    —H.L. Clark, 1887
                </p>
            </x-project.bird.notebook.entry>
            @endif

            <x-project.bird.notebook.entry header="Significant Environmental Threats" 
                :data="$bird->firstMetaByAttribute(510)" />

            @if ($migrationMapLink)
            <x-project.bird.notebook.entry header="Migration Range Map">
                <a href="{{ $migrationMapLink->value }}">
                    {{ $migrationMapLink->value }}
                </a>
            </x-project.bird.notebook.entry>

            @endif
        </div>
    </section>
</main>
@else

<main class="block flex justify-center mt-16">
    <div class="max-w-xs text-center">
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
            {{ optional($bird->firstMetaByAttribute(505))->value ?? null }}
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
                    <x-project.presence-range-month header="19th c." :presence="$presence" />
                @endif
            @endif
        </div>

        <div class="mb-4">
            @if ($twentyfirstBird)
                @php
                    $presence = $twentyfirstBird->firstMetaByAttribute(574);
                @endphp

                @if ($presence)
                    <x-project.presence-range-month header="21st c." :presence="$presence" />
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
                19thc. {{ optional($bird->firstMetaByAttribute(37))->value ?? 'unknown' }};
            </span>
            <span>
                21stc. {{ optional($bird->firstMetaByAttribute(38))->value ?? 'unknown' }}
            </span>
        </p>
    </div>
</main>
@endif
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