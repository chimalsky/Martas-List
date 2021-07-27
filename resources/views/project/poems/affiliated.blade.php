@extends ('layouts.project-shifted')

@section('title')
    {{ $firstline }} - Affiliated Manuscripts - Dickinson's Birds
@endsection

@section('header-anchor')
<a href="@route('project.poems.index')">
    Poem Archive
</a>
@endsection 


@section('header-info')
<a href="@route('project.poems.show', $poem)">
    {{ $firstline }} 
</a> | 
<a class="font-bold" style="color: #B45F06;">
    Affiliated Manuscripts
</a>
<span>
    |
</span>
<a href="@route('project.poems.commentary', $poem)" class="text-gray-500 italic">
    Commentary
</a>
    
<x-project.poem.state />


<x-project.archive-notes title="Poem">
    <x-slot name="content">
        @php
            $content = optional(App\ResourceMeta::find(42072))->value ?? 'No content yet';
        @endphp

        {!! $content !!}
    </x-slot>
</x-project.archive-notes>
@endsection

@section ('content')


<section class="block">
    <h1 style="color: #B45F06;" class="text-3xl font-bold mt-12 mb-10">
        Affiliated <span class="italic">Bird</span> Manuscripts —
    </h1>

    <main class="flex flex-wrap w-full pt-12">
        @foreach ($poems as $poem)
            <article class="pb-32 px-4 w-full lg:w-1/2 xl:w-1/3">
                <a href="@route('project.poems.show', $poem)">
                    <x-project.poem.image :poem="$poem" />
                </a>

                <div class="mt-4 flex justify-center">
                    <div class="w-2/3 text-left">
                        <header class="text-black font-bold mb-2" style="font-family: Cormorant Upright;">
                            <a href="@route('project.poems.show', $poem)" class="inline-block text-xl">
                                {{ $poem->firstLine->value }} 
                            </a>

                            @unless ($poem->doesMentionBirds()) 
                                <div class="inline-block w-8 h-8">
                                    <img src="{{ asset('img/birdless.png') }}" class="object-fit mt-1" />
                                </div>
                            @endunless
                        </header>

                        <main>
                            <p class="">
                                ({{ $poem->franklinId->value }})
                            </p>

                            <p class="">
                                @php
                                    $time = $poem->year->value;

                                    if ($poem->season && $poem->season->value != 'Unknown') {
                                        $time .= ', ' . $poem->season->value;
                                    }

                                    if ($poem->month && $poem->month->value != 'Unknown') {
                                        $time .= ', ' . $poem->month->value;
                                    }

                                @endphp 

                                {{ $time }}
                            </p>

                            <p class="italic">
                                @if ( $poem->custody )
                                    Sent
                                @else 
                                    Retained
                                @endif
                            </p>

                            <p>
                                {{ $poem->medium->value }}, 
                                @if ($poem->isBound())
                                    Bound 
                                @else 
                                    Unbound 
                                @endif 
                            </p>
                        </main>

                        <p>
                            @if ($poem->doesMentionBirds())
                                <span class="font-bold italic">Mentions</span>: 
                                @forelse ($poem->birdCategories as $bird)
                                    {{ $bird->name }}@unless($loop->last),@endunless
                                @empty
                                    Unnamed Birds
                                @endforelse 
                            @else 
                                <span class="font-bold italic">
                                    Sans Birds
                                </span>
                            @endif 
                        </p>
                    </div>
                </div>
            </article> 
        @endforeach
    </main>
</section>

@if ($additionalAffiliations->count())
    @php
        function make_links_clickable($text){
            return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $text);
        }
    @endphp

    <section class="block">
        <h1 style="color: #B45F06;" class="text-3xl font-bold mt-12 mb-4">
            <span class="italic">Additional</span> Manuscripts Affiliations —
        </h1>

        <aside class="max-w-3xl text-lg italic text-center mb-16 mx-auto">
            <x-project.section-break class="mx-auto max-w-lg" />

            <i>Dickinson’s Birds</i> shelters digital surrogates of only those manuscripts by Dickinson that contain
            allusions to birds. Consequently, on occasion a manuscript affiliated with a bird-poem constellation
            but not containing a reference to birds is left out of the present gathering. 
            <br/><br/>
            
            In these cases, the missing
            manuscript or manuscripts are noted below.

            <x-project.section-break class="mx-auto max-w-lg" />
        </aside>

        <main class="flex flex-wrap w-full pt-12">
            @foreach ($additionalAffiliations as $poem) 
                <article class="pb-32 px-4 w-full lg:w-1/2 xl:w-1/3">
                    <a href="@route('project.poems.show', $poem)">
                        <x-project.poem.image :poem="$poem" />
                    </a>

                    <div class="mt-4 flex justify-center">
                        <div class="w-2/3 text-left">
                            <header class="text-black font-bold mb-2" style="font-family: Cormorant Upright;">
                                <a href="@route('project.poems.show', $poem)" class="inline-block text-xl">
                                    {{ $poem->firstLine->value }} 
                                </a>

                                @unless ($poem->doesMentionBirds()) 
                                    <div class="inline-block w-8 h-8">
                                        <img src="{{ asset('img/birdless.png') }}" class="object-fit mt-1" />
                                    </div>
                                @endunless
                            </header>

                            <main>
                                <p class="">
                                    ({{ $poem->franklinId->value }})
                                </p>

                                <p class="">
                                    @php
                                        $time = $poem->year->value;

                                        if ($poem->season && $poem->season->value != 'Unknown') {
                                            $time .= ', ' . $poem->season->value;
                                        }

                                        if ($poem->month && $poem->month->value != 'Unknown') {
                                            $time .= ', ' . $poem->month->value;
                                        }

                                    @endphp 

                                    {{ $time }}
                                </p>

                                <p class="italic">
                                    @if ( $poem->custody )
                                        Sent
                                    @else 
                                        Retained
                                    @endif
                                </p>

                                <p>
                                    {{ $poem->medium->value }}, 
                                    @if ($poem->isBound())
                                        Bound 
                                    @else 
                                        Unbound 
                                    @endif 
                                </p>
                            </main>

                            <p>
                                @if ($poem->doesMentionBirds())
                                    <span class="font-bold italic">Mentions</span>: 
                                    @forelse ($poem->birdCategories as $bird)
                                        {{ $bird->name }}@unless($loop->last),@endunless
                                    @empty
                                        Unnamed Birds
                                    @endforelse 
                                @else 
                                    <span class="font-bold italic">
                                        Sans Birds
                                    </span>
                                @endif 
                            </p>
                        </div>
                    </div>
                </article> 
            @endforeach
        </main>

        <style>
            .additional-affiliation a {
                text-decoration: underline;
                color: blue;
            }
        </style>
    </section>
@endif



<footer class="flex justify-center">
    <img src="{{ asset('img/string.png') }}" class="mx-auto w-64" />
</footer>

@endsection
