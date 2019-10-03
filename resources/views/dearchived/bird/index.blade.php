@extends('layouts.dearchived')

@section('content')

@if ($year > 2000)
    All the birds have been wiped out due to human activity and economic growth
@else 
    @foreach($birds as $bird)
        <article class="p-3 w-full md:w-1/2 lg:w-1/3 max-w-xs">
            <section class="p-2 flex flex-wrap">
                @if ($audio = $bird->getMedia('', function($medium) { return Str::contains($medium->mime_type, 'audio'); })->random() ?? false)
                    <audio controls class="invisible" id="birdsong-{{ $bird->id }}"
                    src="{{ $audio->getUrl() }}" autoplay preload="auto">
                        Your browser does not support the
                        <code>audio</code> element.
                    </audio>
                @endif

                @foreach ($bird->resources as $poem)
                    @foreach ($poem->getMedia('', function($medium) { return Str::contains($medium->mime_type, 'image'); }) as $manuscript)
                        <div data-controller="draggable frame" data-draggable-media="{{ $bird->id }}" data-frame-media="{{ $bird->id }}"
                            class="my-16 bird text-center ">
                            {{ $bird->name }}
                            <nav class="draggable-handle bg-red-400 h-4 w-2 mx-auto cursor-move"></nav>
                            <section class="draggable-handle bg-red-400 rounded-full cursor-move">
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

<nav class="fixed timeline bottom-0 left-0 w-full pb-8 pl-4">
    <section class="flex max-w-lg mx-auto justify-center mb-4">
        @foreach ($months as $m)
            <div class="">
                <a href="{{ route('dearchived.bird.show', ['month' => $m]) }}" 
                    class="p-2 h-2 w-2 rounded-full dot @if($month == $m) active @endif">
                </a>

                @unless ($loop->last)
                    <span class="w-6 border-b-2 border-black inline-block align-middle"></span>
                @endunless
            </div>
        @endforeach
    </section>

    <section class="flex justify-between max-w-lg mx-auto">
        <a href="{{ route('dearchived.bird.show', ['year' => 1863, 'month' => $month]) }}" class="text-xl font-thin @if($year == 1863) font-semibold @endif">
            1863
        </a>
        <a href="{{ route('dearchived.bird.show', ['year' => 2019, 'month' => $month]) }}" class="text-xl font-thin ml-4 @if($year == 2019) font-semibold @endif">
            2019
        </a>
    </section>

    <footer class="text-right max-w-lg mx-auto mt-4 text-sm">
        The Arrivals and Departures of Dickinson's Birds
    </footer>
</nav>
@endsection