@extends ('layouts.project-shifted')

@section('title')
    {{ $firstline }} - Dickinson's Birds
@endsection

@section('header-anchor')
<a href="@route('project.poems.index')">
    Poem Archive
</a>
@endsection 


@section('header-info')
<span class="font-bold" style="color:#B45F06">
    {{ $firstline }}
</span> | 
@if($poem->category) 
    <a href="@route('project.affiliated.poems', $poem)" style="color: #806102">
        Affiliated Manuscripts
    </a>
@else 
    <span class="text-gray-500 italic">
        Affiliated Manuscripts
    </span>
@endif
<span>
    |
</span>
<a href="@route('project.poems.commentary', $poem)" class="text-gray-500 italic">
    Commentary
</a>
@endsection


@section ('content')

@auth
    <div class="flex justify-center my-4">
        <a href="{{ route('resources.edit', $poem) }}" class="no-underline border border-gray-500 p-2 hover:underline font-normal text-teal-800">
            View/Edit Data 
        </a>
    </div>
@endauth

<section class="text-center max-w-2xl mx-auto mt-10">
    @php
            $time = $poem->year->value;
            if ($poem->season && $poem->season->value != 'Unknown') {
                $time .= ', ' . $poem->season->value;
            }

            if ($poem->month && $poem->month->value != 'Unknown') {
                $time .= ', ' . $poem->month->value;
            }
    @endphp 

    @if ($poem->doesMentionBirds())
        <p class="font-bold">
            {{ $poem->msId->value }} 
            ({{ $poem->franklinId->value }})
        </p>

        <p class="mb-4">
            {{ $time }}
        </p>

        <p>
            {{ $poem->medium->value }}, {{ $poem->manuscriptState->value }}.
        </p>

        @if ($poem->manuscriptSetting) 
            <p>
                <span class="italic">
                    MS Retained
                </span>
                @if ($poem->isBound())
                    Bound 
                @else 
                    Unbound 
                @endif 

                @unless ($poem->manuscriptSetting->value == 'Unknown')
                    ({{ $poem->manuscriptSetting->value }}).
                @else 
                    Unknown setting.
                @endunless 

                @if ($poem->enclosures)
                    Contains {{ $poem->enclosures->value }}
                @endif
            </p>
        @endif

        @if ($poem->custody)
            <p>
                {{ $poem->custody->value }}
            </p>
        @endif
    @else 
        <div class="mx-auto w-16 h-16">
            <img src="{{ asset('img/birdless.png') }}" class="object-fit" />
        </div>

        <p class="font-bold text-xl">
            {{ $time }}
        </p>

        <p>
            {{ $poem->manuscriptState->value }} copy, in {{ $poem->medium->value }}
        </p>

        @if ($poem->manuscriptSetting) 
            <p>
                <span class="italic">
                    Preserved in Dickinson's private archive;
                </span>
                @if ($poem->isBound())
                    Bound 
                @else 
                    Unbound 
                @endif 
                ({{ $poem->manuscriptSetting->value }}).
            </p>
        @endif
    @endif
</section>


<section class="mt-12 max-w-4xl mx-auto">
    <livewire:project.poem.transcription-viewer :poem="$poem" />
</section>

<section id="birds" class="mt-10 mb-10 text-center">
    @if ($birds->count())
    <h1 class="text-2xl text-orange-700 mb-6">
        Birds circulating in this MS —
    </h1>
    
    <main class="flex flex-wrap justify-center">
        @foreach ($birds as $bird)
            <article class="bird pt-2 pb-6 px-4 w-full lg:w-1/2 xl:w-1/3">
                @include('project.birds._single', [$bird, 'hideMeta' => true])
            </article>
        @endforeach
    </main>
    @else 
        <h1 class="text-xl text-orange-700">
            <span class="italic">
                {{ $firstline }}
            </span> mentions Unnamed Birds.
        </h1>

        <div class="my-4 text-2xl">
            View the <a class="underline" href="@route('project.birds.index')">
                Bird Archive
            </a>
        </div>
    @endif
</section>

@endsection
