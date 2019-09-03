@extends('layouts.dearchived')

@section('content')

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
                    <div data-controller="draggable frame" data-draggable-media="{{ $bird->id }}"
                        class="max-h-screen h-auto xl:h-48 my-16">
                        <nav class="draggable-handle bg-red-400 h-4 w-2 mx-auto cursor-move"></nav>
                        <section class="draggable-handle bg-red-400 rounded-full pt-4 cursor-move">
                            <div class="rounded-full cursor-pointer overflow-hidden"
                                data-target="frame.container">

                                <p data-target="frame.text" class="text-center hidden text-2xl mt-24 px-1">
                                    {!! $manuscript->model->resources->firstWhere('resource_type_id', 4)->excerpt !!}
                                </p>
            
                                <img src="{{ $manuscript->getUrl() }}" 
                                    data-action="click->frame#zoomImg"
                                    class="w-full z-10"/>
                            </div>
                        </section>
                    </div>
                @endforeach 
            @endforeach
        </section>
    </article>
@endforeach

<nav class="fixed bottom-0 left-0 w-full flex justify-center pb-8 pl-4 text-xl season-{{ $season }}">
    {{ html()->form('GET', route('dearchived.bird.show'))->open() }}
        <input type="submit" name="season" value="spring" class="bg-transparent p-2 rounded-full @if($season == 'spring') font-bold @endif">
        <input type="submit" name="season" value="summer" class="bg-transparent p-2 rounded-full @if($season == 'summer') font-bold @endif">
        <input type="submit" name="season" value="fall" class="bg-transparent p-2 rounded-full @if($season == 'fall') font-bold @endif">
        <input type="submit" name="season" value="winter" class="bg-transparent p-2 rounded-full @if($season == 'winter') font-bold @endif">
    {{ html()->form()->close() }}
</nav>
@endsection