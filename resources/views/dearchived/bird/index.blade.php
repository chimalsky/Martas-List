@extends('layouts.dearchived')

@section('content')

@foreach($birds->slice(0,5) as $bird)
    <article class="p-3 w-full md:w-1/2 lg:w-1/3 xl:w-1/4 text-gray-200">
        <section class="p-2 flex flex-wrap">
            {{ $bird->name }}

            @if ($audio = $bird->getMedia('', function($medium) { return Str::contains($medium->mime_type, 'audio'); })->last() ?? false)
                <audio controls class="invisible" id="birdsong-{{ $bird->id }}"
                src="{{ $audio->getUrl() }}">
                    Your browser does not support the
                    <code>audio</code> element.
                </audio>
            @endif

            @foreach ($bird->resources as $poem)
                @foreach ($poem->getMedia('', function($medium) { return Str::contains($medium->mime_type, 'image'); }) as $image)
                    <section data-controller="draggable" data-draggable-media="{{ $bird->id }}"
                        class="max-h-screen my-16 z-0">
                        <div data-controller="frame" class="rounded-full cursor-move overflow-hidden"
                            data-target="frame.container">
                            <img src="{{ $image->getUrl() }}" 
                                data-action="click->frame#zoomImg"
                                class="w-full z-10"/>
                        </div>

                        <nav class="draggable-handle p-4 h-4 w-4 bg-red-400 z-20">
                        </nav>
                    </section>
                @endforeach 
            @endforeach
        </section>
    </article>
@endforeach

<nav class="fixed bottom-0 left-0 w-2/5 bg-gray-500 pb-8 pl-4 text-xl">
</nav>
@endsection