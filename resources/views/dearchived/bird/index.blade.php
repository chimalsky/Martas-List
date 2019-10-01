@extends('layouts.dearchived')

@section('content')

@if ($year > 2000)
    All the birds have been wiped out due to human activity and economic growth
@else 
    @foreach($birds as $bird)
        <article class="p-3 w-full md:w-1/2 lg:w-1/3 max-w-xs">
            <section class="p-2 flex flex-wrap">
                {{ $bird->name }}

                @if ($audio = $bird->getMedia('', function($medium) { return Str::contains($medium->mime_type, 'audio'); })->random() ?? false)
                    <audio controls class="invisible" id="birdsong-{{ $bird->id }}"
                    src="{{ $audio->getUrl() }}">
                        Your browser does not support the
                        <code>audio</code> element.
                    </audio>
                @endif

                @foreach ($bird->resources as $poem)
                    @foreach ($poem->getMedia('', function($medium) { return Str::contains($medium->mime_type, 'image'); }) as $manuscript)
                        <div data-controller="draggable frame" data-draggable-media="{{ $bird->id }}" data-frame-media="{{ $bird->id }}"
                            class="my-16">
                            <nav class="draggable-handle bg-red-400 h-4 w-2 mx-auto cursor-move"></nav>
                            <section class="draggable-handle bg-red-400 rounded-full pt-4 cursor-move">
                                <div class="rounded-full cursor-pointer overflow-hidden h-64 w-64"
                                    data-target="frame.container">

                                    <p data-target="frame.text" class="text-center hidden text-2xl mt-24 px-1">
                                        {!! $manuscript->model->resources->firstWhere('resource_type_id', 4)->excerpt !!}
                                    </p>

                                    <div class="container h-full w-full overflow-hidden">
                                        <img src="{{ $manuscript->getUrl() }}" 
                                        
                                            class="z-10" style="max-width: none"/>
                                    </div>
                                </div>
                            </section>
                        </div>
                    @endforeach 
                @endforeach
            </section>
        </article>
    @endforeach
@endif

<nav class="fixed bottom-0 left-0 w-full pb-8 pl-4">
    <section class="block flex justify-center">
        @foreach ($months as $m)
        <a href="{{ route('dearchived.bird.show', ['month' => $m]) }}" 
            class="tracking-wider capitalize p-2 @if($month == $m) font-bold @endif">
            {{ substr($m, 0, 3) }}
        </a>
        @endforeach
    </section>

    <footer class="flex justify-between max-w-lg mx-auto">
        <a href="" class="text-xl font-semibold">
            1863
        </a>
        <a href="{{ route('dearchived.bird.show', ['year' => 2019]) }}" class="text-xl ml-4">
            2019
        </a>
    </footer>
</nav>
@endsection