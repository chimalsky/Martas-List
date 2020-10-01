@extends ('layouts.project-shifted')

@section('header-anchor')
<a href="@route('project.poems.index')" class=''>
    <div>
        <span class="text-4xl">P</span>OEM 

        <span class="text-4xl">A</span>RCHIVE
    </div>
</a>
@endsection 


@section('header-info')
{{ $firstline }} | 
@if($poem->category) 
    <a class="text-black underline italic" href="@route('project.affiliated.poems', $poem)">
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
<a href="" class="text-gray-500">
    Commentary
</a>
@endsection


@section ('content')

<section class="text-center">
    <p class="mt-18 text-black text-lg">
        {{ $season }} {{ $year }}
    </p>

    <p class="text-base text-gray-600">
        {{ $state }}
        <br/>
        {{ $setting }}, {{ $circulation }}
    </p>

    <p class="mt-2 text-gray-600 hidden">

        Copied in 
        {{ $poem->meta->where('resource_attribute_id', 142)->first()->value ?? null }}
        on 
        {{ $poem->meta->where('resource_attribute_id', 87)->first()->value ?? null }},
        bound into
        {{ $poem->meta->where('resource_attribute_id', 3)->first()->value ?? null }}
    </p>
</section>

<section class="mt-12 flex flex-wrap">
    <div class="w-1/3 mt-40">
        <!-- Manuscript Transcription -->
        {!! $poem->meta->where('resource_attribute_id', 78)->first()->value ?? null !!}
    </div>

        <div class="w-2/3 md:pl-4 lg:pl-8">
            @if ($poem->media()->exists())
                <livewire:project.media-viewer :resource="$poem" />
            @endif
        </div>
</section>

<section id="birds" class="mt-12 lg:mt-24 mb-10">
    @if ($birds->count())
    <h1 class="text-2xl text-orange-700">
        Birds circulating in this MS --
    </h1>
    
    <main class="flex flex-wrap">
        @foreach ($birds as $bird)
        <a href="@route('project.birds.show', $bird)" class="p-4 w-full md:w-1/2 lg:w-1/3">
            <article class="bird border-2 border-gray-400  shadow-lg hover:shadow-2xl rounded-lg pt-2 pb-6 px-4">
                @include('project.birds._single', $bird)
            </article>
        </a>
        @endforeach
    </main>
    @else 
        <h1 class="text-xl text-orange-700">
            {{ $firstline }} mentions no birds
        </h1>
    @endif
</section>

@endsection