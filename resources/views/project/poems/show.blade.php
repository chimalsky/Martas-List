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
    <p class="mt-18 text-black text-lg">
        {{ $year }} {{ $season }}
    </p>

    <p class="text-base text-gray-600">
        {{ $medium }}. {{ $state }}.
        <br/>
        {{ $setting }}, {{ $circulation }}.
    </p>

    <p class="mt-2 text-gray-600 hidden">
        Copied in 
        {{ optional($poem->meta->firstWhere('resource_attribute_id', 142))->value }}
        on 
        {{ optional($poem->meta->firstWhere('resource_attribute_id', 87))->value }},
        bound into
        {{ optional($poem->meta->firstWhere('resource_attribute_id', 3))->value }}
    </p>
</section>

<section class="mt-12 max-w-4xl mx-auto">
    @if ($poem->media()->exists())
        <livewire:project.poem.transcription-viewer :poem="$poem" />
    @endif
</section>

<section id="birds" class="mt-12 lg:mt-24 mb-10">
    @if ($birds->count())
    <h1 class="text-2xl text-orange-700 mb-10">
        Birds circulating in this MS --
    </h1>
    
    <main class="flex flex-wrap">
        @foreach ($birds as $bird)
            <article class="bird shadow-lg pt-2 pb-6 px-4 w-full lg:w-1/2 xl:w-1/3">
                @include('project.birds._single', $bird)
            </article>
        @endforeach
    </main>
    @else 
        <h1 class="text-xl text-orange-700">
            {{ $firstline }} - unnamed birds.
        </h1>

        <div class="my-4 text-2xl">
            View <a class="underline" href="@route('project.birds.index')">
                Bird Archive
            </a>
        </div>
    @endif
</section>

@endsection