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

@section('content')


@auth
    <div class="flex justify-center my-4">
        <a href="{{ route('resources.edit', $bird) }}" class="no-underline border border-gray-500 p-2 hover:underline font-normal text-teal-800">
            View/Edit Data 
        </a>
    </div>
@endauth

<header class="mb-8 flex">

    <div class="mx-auto">
        <div class="grid grid-cols-2 gap-4">
            <x-project.bird.xc :bird="$bird" class="col-span-1" />
            
            @isset ($birdCategory)
                <div class="col-span-1 text-center">
                    "{{ $birdCategory->name }}" appears in {{ $poems->count() }} 
                    <a href="#poems">
                        @if ($poems->count() === 1)
                            Poem
                        @else 
                            Poems
                        @endif
                    </a>
                </div>
            @endisset
        </div>

    </div>
</header>

@php
    $nineteenthBird = $bird->resources->firstWhere('resource_type_id', 8);
    $twentiethBird = $bird->resources->firstWhere('resource_type_id', 14);
    $twentyfirstBird = $bird->resources->firstWhere('resource_type_id', 15);

    $migrationMapLink = $bird->firstMetaByAttribute(506)
@endphp

<main class="text-center max-w-sm mx-auto">
    <x-project.bird.notebook.entry header="Occurence in Amhrest & Connecticut Valley Mass.">
        @isset ($nineteenthBird)
            <x-project.bird.presence class="mb-4 text-lg" century="19" :bird="$nineteenthBird" />
        @endisset 

        @isset ($twentiethBird)
            <x-project.bird.presence class="mb-4 text-lg" century="20" :bird="$twentiethBird" />
        @endisset 
        
        @isset ($twentyfirstBird)
            <x-project.bird.presence class="mb-4 text-lg" century="21" :bird="$twentyfirstBird" />
        @endisset 

    </x-project.bird.notebook.entry>

    <x-project.bird.notebook.entry header="Habitat" class="text-lg" :data="$bird->firstMetaByAttribute(504)" />

    <x-project.bird.notebook.entry header="Nest Materials" class="text-lg" :data="$bird->firstMetaByAttribute(505)" />

    @php 
        $fieldNotes = $nineteenthBird  
            ? $nineteenthBird->firstMetaByAttribute(590)
            : null;
    @endphp
    @if ($fieldNotes)
    <x-project.bird.notebook.entry header="19th-20th Century Field Notes" class="text-lg" :noSmallCaps="true" :data="$fieldNotes">
        <p class="text-right">
            —H.L. Clark, 1887
        </p>
    </x-project.bird.notebook.entry>
    @endif

    <x-project.bird.notebook.entry header="21st Century Conservation Notes" :noSmallCaps="true" :data="$bird->firstMetaByAttribute(37)">
        <p class="text-lg">
            {{ optional($bird->firstMetaByAttribute(596))->value ?? 'Information Coming Soon' }}
        </p>

        <p class="mt-4">
            (source: Audubon’s online Field Guide to North American Birds)
        </p>
    </x-project.bird.notebook.entry>
</main>



@if ($bird->category)
<main class="relative hidden ml-48">
    <img src="{{ asset('img/bird-notebook.png') }}" />
    <section class="absolute inset-0 flex flex-wrap py-32 pr-48 pl-48">
        <div class="w-2/5 pr-18 overflow-auto" style="max-height: 80%;">
            <x-project.bird.notebook.entry header="Occurence in Amhrest & Connecticut Valley Mass.">
                @isset ($nineteenthBird)
                    <x-project.bird.presence class="mb-4" century="19" :bird="$nineteenthBird" />
                @endisset 

                @isset ($twentiethBird)
                    <x-project.bird.presence class="mb-4" century="20" :bird="$twentiethBird" />
                @endisset 
                
                @isset ($twentyfirstBird)
                    <x-project.bird.presence class="mb-4" century="21" :bird="$twentyfirstBird" />
                @endisset 

            </x-project.bird.notebook.entry>

            <x-project.bird.notebook.entry header="Habitat" :data="$bird->firstMetaByAttribute(504)" />

            <x-project.bird.notebook.entry header="Nest Material" :data="$bird->firstMetaByAttribute(505)" />

            
        </div>


        <div class="w-3/5 pl-32 pr-8 overflow-auto" style="max-height: 80%;">
            <x-project.bird.notebook.entry header="Conservation Notes" :data="$bird->firstMetaByAttribute(37)">
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

<main class="relative xl:hidden ">
    <x-project.bird.notebook.entry header="Occurence in Amhrest Connecticut & Valley Mass.">
        @isset ($nineteenthBird)
            <x-project.bird.presence class="mb-4" century="19" :bird="$nineteenthBird" />
        @endisset 

        @isset ($twentiethBird)
            <x-project.bird.presence class="mb-4" century="20" :bird="$twentiethBird" />
        @endisset 
        
        @isset ($twentyfirstBird)
            <x-project.bird.presence class="mb-4" century="21" :bird="$twentyfirstBird" />
        @endisset 
    </x-project.bird.notebook.entry>

    <x-project.bird.notebook.entry header="Habitat" :data="$bird->firstMetaByAttribute(504)" />

    <x-project.bird.notebook.entry header="Nest Material" :data="$bird->firstMetaByAttribute(505)" />

    <x-project.bird.notebook.entry header="Conservation Notes" :data="$bird->firstMetaByAttribute(37)">
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
</main>
@else

<main class="hidden justify-center mt-16">
    <div class="max-w-xs text-center">
        <p class="text-2xl font-hairline">
            Habitat 
        </p>
        <p>
            {{ optional($bird->firstMetaByAttribute(504))->value ?? 'Unknown' }}
        </p>
 
        <p class="text-2xl font-hairline mt-6">
            Nest Material 
        </p>
        <p>
            {{ optional($bird->firstMetaByAttribute(505))->value ?? 'Unknown' }}
        </p>

        <p class="text-2xl font-hairline mt-6 mb-4">
            Seasons in Amherst, MA
        </p>
        <div class="">
            @isset ($nineteenthBird)
                <x-project.bird.presence class="mb-4" century="19" :bird="$nineteenthBird" />
            @endisset 

            @isset ($twentiethBird)
                <x-project.bird.presence class="mb-4" century="20" :bird="$twentiethBird" />
            @endisset 
            
            @isset ($twentyfirstBird)
                <x-project.bird.presence class="mb-4" century="21" :bird="$twentyfirstBird" />
            @endisset 
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
            Conservation Notes
        </p>
        <div>
            <p>
                19th c. {{ optional($bird->firstMetaByAttribute(37))->value ?? 'Information Coming Soon' }};
            </p>
            <p>
                21st c. {{ optional($bird->firstMetaByAttribute(38))->value ?? 'Information Coming Soon' }}
            </p>
        </div>
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