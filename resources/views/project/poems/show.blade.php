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
        {{ optional($poem->meta->firstWhere('resource_attribute_id', 142))->value }}
        on 
        {{ optional($poem->meta->firstWhere('resource_attribute_id', 87))->value }},
        bound into
        {{ optional($poem->meta->firstWhere('resource_attribute_id', 3))->value }}
    </p>
</section>

<section class="mt-12 flex flex-wrap">
    <div id="js-transcription-source" class="h-0 w-0 opacity-0">
        <!-- Manuscript Transcription -->
        {!! optional($poem->meta->firstWhere('resource_attribute_id', 78))->value !!}
    </div>

    <div id="js-transcription-display" class="w-full md:w-1/3 lg:w-1/2 mt-40 text-2xl">
    </div>

    <script>
        let source = document.querySelector('#js-transcription-source');
        let display = document.querySelector('#js-transcription-display');

        let transcriptionText = source.innerText;

        let splitText = transcriptionText.split("{/pb}");

        splitText.forEach(function(page, i) {
            let div = document.createElement('div');
            div.innerText = page;
            div.setAttribute('page-index', i)

            display.appendChild(div);
        });
        
        source.classList.add('hidden');

        showPageByIndex(0);

        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('media-viewer:pageChanged', pageIndex => {
                showPageByIndex(pageIndex);
            });
        });

        function showPageByIndex(index) {
            let selectedText = document.querySelector(`#js-transcription-display div[page-index="${index}"]`)

            document.querySelectorAll('#js-transcription-display div').forEach(function(div) {
                div.classList.add('hidden');
            });

            selectedText.classList.remove('hidden');
        }
    </script>

    <div class="w-full md:w-2/3 lg:w-1/2 md:pl-4 lg:pl-8">
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