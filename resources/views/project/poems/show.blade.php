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
<span style="color:#B45F06">
    {{ $firstline }}
</span> | 
@if($poem->category) 
    <a class="text-black" href="@route('project.affiliated.poems', $poem)">
        Affiliated Manuscripts
    </a>
@else 
    <span class="text-gray-500">
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

<section class="text-center max-w-2xl mx-auto">
    @foreach ($poem->metaByAttribute(597)->pluck('value') as $line)
        <p>
            {{ $line }}
        </p>
    @endforeach
</section>


<section class="mt-12 max-w-4xl mx-auto">
    <livewire:project.poem.transcription-viewer :poem="$poem" />
</section>

<section id="birds" class="mt-10 mb-10 text-center">
    @if ($birds->count())
    <h1 class="text-2xl text-orange-700 mb-6">
        Birds circulating in this MS --
    </h1>
    
    <main class="flex flex-wrap justify-center">
        @foreach ($birds as $bird)
            <article class="bird shadow-lg pt-2 pb-6 px-4 w-full lg:w-1/2 xl:w-1/3">
                @include('project.birds._single', $bird)
            </article>
        @endforeach
    </main>
    @else 
        <h1 class="text-xl text-orange-700">
            <span class="italic">
                {{ $firstline }}
            </span> mentions unnamed birds.
        </h1>

        <div class="my-4 text-2xl">
            View <a class="underline" href="@route('project.birds.index')">
                Bird Archive
            </a>
        </div>
    @endif
</section>

@endsection