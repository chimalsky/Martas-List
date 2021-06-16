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
                            {{ $poem->firstMetaByAttribute(84)->value }}
                        </header>

                        @foreach ($poem->metaByAttribute(597)->pluck('value') as $line)
                            <p @if ($loop->index === 2)
                                class="italic"
                                @endif
                                style="font-family: Cormorant; margin-bottom: .1rem;">
                                {{ $line }}
                            </p>
                        @endforeach

                        <p>
                            @if ($poem->doesMentionBirds())
                                <span class="font-bold italic">Mentions</span>: 
                                @foreach ($poem->birdCategories as $bird)
                                    {{ $bird->name }}@unless($loop->last),@endunless
                                @endforeach 
                            @else 
                                Sans Birds
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

        <aside class="max-w-3xl text-lg italic text-center mb-16">
            <x-project.section-break class="mx-auto max-w-lg" />

            <i>Dickinson’s Birds</i> shelters digital surrogates of only those manuscripts by Dickinson that contain
            allusions to birds. Consequently, on occasion a manuscript affiliated with a bird-poem constellation
            but not containing a reference to birds is left out of the present gathering. 
            <br/><br/>
            
            In these cases, the missing
            manuscript or manuscripts are noted below.

            <x-project.section-break class="mx-auto max-w-lg" />
        </aside>

        @foreach ($additionalAffiliations as $additional) 
            <article class="mb-10 block text-xl max-w-3xl additional-affiliation">
                @php 
                    echo make_links_clickable($additional->value);
                @endphp
            </article> 
        @endforeach

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
