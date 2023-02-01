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

@auth
    <div class="flex justify-center my-4">
        <a href="{{ route('resources.edit', $poem) }}" class="no-underline border border-gray-500 p-2 hover:underline font-normal text-teal-800">
            View/Edit Data 
        </a>
    </div>
@endauth

<section class="text-center max-w-4xl mx-auto mt-10">
    @php
        $time = $poem->year->value;

        if ($poem->month && $poem->month->value != 'Unknown') {
            $time .= ', ' . $poem->month->value;
        } else {
            if ($poem->season && $poem->season->value != 'Unknown') {
                $time .= ', ' . $poem->season->value;
            }
        }
    @endphp 

    @if ($poem->manuscriptSetting)
        <p class="font-bold">
            {{ $poem->msId->value }} 
            ({{ $poem->franklinId->value }})
        </p>

        <p class="">
            {{ $time }}
        </p>

        <p>
            {{ $poem->medium ? $poem->medium->value : $medium }} | 
            {{ $poem->manuscriptState->value }}
            @if ($poem->mutilated)
                (mutilated)
            @endif
            @if ($poem->missingLeaves)
                (missing leaves)
            @endif
            |
            @if ($poem->isBound())
                Bound 
            @else 
                Unbound 
            @endif 
            ({{ $poem->manuscriptSetting->value }})
        </p>

        <p>
            @if ($poem->isRetained()) 
                <span class="italic">
                    Retained in Dickinson's archive.
                </span>
            @endif 
            
            @if ($poem->circulation && str_contains($poem->circulation->value, 'unknown'))
                <span class="italic">
                    Circulation status unknown.
                </span>
            @endif

            @if ($poem->circulation->value == 'unknown')
                <span class="italic">Circulation status unknown.</span>
            @else
                @if ($poem->formOfSentPoem)
                    @if (strtolower($poem->formOfSentPoem->value) == 'poem-message')
                        <span class="italic">Poem-message to</span>
                    @endif
                    @if (strtolower($poem->formOfSentPoem->value) == 'poem')
                        <span class="italic">Poem sent to</span>
                    @endif
                    @if (strtolower($poem->formOfSentPoem->value) == 'poem embedded in a message')
                        <span class="italic">Poem embedded in a message to</span>
                    @endif
                    @if (strtolower($poem->formOfSentPoem->value) == 'poem enclosed in a message')
                        <span class="italic">Poem enclosed in a message to</span>
                    @endif
                    @if (strtolower($poem->formOfSentPoem->value) == 'poem embedded in a letter draft (uncirculated)')
                        <span class="italic">Poem embedded in a letter draft (uncirculated) to</span>
                    @endif

                    Circulation History ({{ $poem->circulation->value }}).
                @endif
            @endif
        </p>

        @if ($poem->enclosures)
            <p>
                <span class="font-bold">Enclosures:</span>
                {{ $poem->enclosures->value }}
            </p>
        @endif
    @else 
        <p class="font-bold">
            ({{ $poem->franklinId->value }})
        </p>

        <p class="">
            {{ $time }}
        </p>
        
        <p>
            {{ $poem->medium ? $poem->medium->value : $medium }} | 
            {{ $poem->manuscriptState->value }}
            @if ($poem->mutilated)
                (mutilated)
            @endif
            @if ($poem->missingLeaves)
                (missing leaves)
            @endif
            |
            @if ($poem->isBound())
                Bound 
            @else 
                Unbound 
            @endif 
        </p>

        <p>
            @if ($poem->circulation && str_contains($poem->circulation->value, 'unknown'))
                <span class="italic">
                    Circulation status unknown.
                </span>
            @endif

            @if ($poem->circulation->value == 'unknown')
                <span class="italic">Circulation status unknown.</span>
            @else
                @if ($poem->formOfSentPoem)
                    @if (strtolower($poem->formOfSentPoem->value) == 'poem-message')
                        <span class="italic">Poem-message to</span>
                    @endif
                    @if (strtolower($poem->formOfSentPoem->value) == 'poem')
                        <span class="italic">Poem sent to</span>
                    @endif
                    @if (strtolower($poem->formOfSentPoem->value) == 'poem embedded in a message')
                        <span class="italic">Poem embedded in a message to</span>
                    @endif
                    @if (strtolower($poem->formOfSentPoem->value) == 'poem enclosed in a message')
                        <span class="italic">Poem enclosed in a message to</span>
                    @endif
                    @if (strtolower($poem->formOfSentPoem->value) == 'poem embedded in a letter draft (uncirculated)')
                        <span class="italic">Poem embedded in a letter draft (uncirculated) to</span>
                    @endif

                    Circulation History ({{ $poem->circulation->value }}).
                @endif
            @endif
        </p>

        <p>
            @php
                $transcript19th = $poem->meta()->firstWhere('resource_attribute_id', 150)
            @endphp

            Original MS lost or destroyed
            @if ($transcript19th) 
                | {{ $transcript19th->value }}
            @endif
        </p>

        @if ($poem->enclosures)
            <p>
                <span class="font-bold">Enclosures:</span>
                {{ $poem->enclosures->value }}
            </p>
        @endif
    @endif
</section>

<section class="xl:flex xl:justify-center">
    <div class="xl:w-4/5 mt-12 xl:flex">
        <div class="flex-1 max-w-md">
            <livewire:project.poem.transcription-viewer :poem="$poem" />
        </div>
        <div id="birds" class="mt-10 mb-10 text-center flex-1 flex items-center">
            <div class="mx-auto">
                @if ($poem->environmentalPhenomenaSpecific()->count())
                    <div class="text-3xl italic mb-12 max-w-md mx-auto">
                        @foreach ($poem->environmentalPhenomenaSpecific as $phenomenon)
                            <a href="@route('project.poems.index', ['filterable[701]' => $phenomenon->value])" target="_blank"
                                class="hover:underline">
                                {{ ucfirst($phenomenon->value) }}
                            </a>
                            @if (!$loop->last)
                                +
                            @endif
                        @endforeach
                    </div>
                @endif
                @if ($birds->count())
                <main class="flex flex-wrap justify-center gap-4 lg:gap-12">
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
            </div>
        </div>
    </div>
</section

@if ($poem->wasSent() && $recipients->count())
    <section class="text-center max-w-2xl mx-auto mt-10">
        <header class="text-2xl" style="color: #CC9A00;">
            Recipient
        </header>
        @foreach ($recipients as $recipient)
            <p class="font-bold text-lg">{{ $recipient->name }}</p>
            
            <p class="italic">
                @php
                    $relationship = $recipient->meta()->where('resource_attribute_id', 286)->first();
                    $datesOfCorrespondence = $recipient->meta()->where('resource_attribute_id', 287)->first();
                    $connections = $recipient->connections->pluck('resources')->flatten();
                    $addresses = $connections->where('resource_type_id', 10);
                    $address = $addresses->first();
                    if ($address) {
                        $addressMeta = $address->meta()->firstWhere('resource_attribute_id', 254);
                        $transit = $poem->connections->pluck('resources')->flatten()->firstWhere('resource_type_id', 9);
                        $distanceTravelled = $transit->meta()->firstWhere('resource_attribute_id', 592);
                    }
                @endphp
                @if ($relationship)
                    {{ $relationship->value }}
                @endif
            </p>

            @if ($datesOfCorrespondence)
                <p>
                    <span class="font-bold">Inclusive dates of correspondence:</span>
                    {{ $datesOfCorrespondence->value }}
                </p>
            @endif

            @if ($address)
                <p>
                    <span class="font-bold">Address:</span>
                    {{ $addressMeta->value }}
                </p>

                @if ($distanceTravelled)
                    <p>
                        <span class="font-bold">Distance Travelled:</span>
                        {{ $distanceTravelled->value }}
                    </p>
                @endif
            @endif
        @endforeach
    </section>
@endif

@endsection
