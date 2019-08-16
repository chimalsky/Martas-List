@extends('layouts.dearchived')

@section('content')

@foreach($birds as $bird)
    <article class="p-3">
        {{ $bird->name }}

        <section class="bg-gray-300 p-2">
            @foreach ($bird->getMedia() as $medium)
                <audio controls
                src="{{ $medium->getUrl() }}">
                    Your browser does not support the
                    <code>audio</code> element.
                </audio>
            @endforeach

            @foreach ($bird->resources as $poem)
                @foreach ($poem->getMedia() as $medium)
                    <img src="{{ $medium->getUrl() }}" />
                @endforeach
            @endforeach
        </section>
    </article>
@endforeach

@endsection