@extends('layouts.dearchived')

@section('content')

@foreach($birds->where('name', 'Bobolink') as $bird)
    <article class="p-3">
        {{ $bird->name }}

        <section class="p-2 text-gray-200 flex flex-wrap">
            <section data-controller="frame" class="w-full md:w-1/2 max-h-screen"
                data-target="frame.container" >
                @foreach ($bird->resources as $poem)
                    @foreach ($bird->getMedia('', function($medium) { return Str::contains($medium->mime_type, 'audio'); }) as $audio)
                        <audio controls
                        src="{{ $audio->getUrl() }}">
                            Your browser does not support the
                            <code>audio</code> element.
                        </audio>
                    @endforeach
                    @foreach ($poem->getMedia('', function($medium) { return Str::contains($medium->mime_type, 'image'); }) as $image)
                            <div class="rounded-full cursor-move">
                                <img src="{{ $image->getUrl() }}" 
                                class="w-full object-none"
                                />
                            </div>
                    @endforeach
                @endforeach
            </section>

        </section>
    </article>
@endforeach

@endsection