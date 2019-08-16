@extends('layouts.dearchived')

@section('content')

@foreach($birds as $bird)
    <article class="p-3">
        {{ $bird->name }}

        <section class="bg-gray-300 p-2">
            <audio controls
              src="{{ $bird->getFirstMediaUrl() }}">
                Your browser does not support the
                <code>audio</code> element.
            </audio>
        </section>
    </article>
@endforeach

@endsection