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
