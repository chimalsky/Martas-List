@extends('layouts.dearchived')

@section('content')

@foreach($birds as $bird)
    <article class="p-3 w-full md:w-1/2 text-gray-200">
        <section class="p-2 flex flex-wrap">
            <section data-controller="frame" class="max-h-screen"
                data-target="frame.container" >
                    {{ $bird->name }}

                    
                    @if ($audio = $bird->getMedia('', function($medium) { return Str::contains($medium->mime_type, 'audio'); })->first() ?? false)
                        <audio controls
                        src="{{ $audio->getUrl() }}">
                            Your browser does not support the
                            <code>audio</code> element.
                        </audio>
                    @endif
                    @foreach ($bird->resources as $poem)
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