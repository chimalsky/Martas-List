@extends ('layouts.project')

@section('title')
    Colophon - Dickinson's Birds
@endsection

@php
    $header = true;
@endphp
@section ('header')
    <div class="mt-8 max-w-2xl mx-auto">
        @include('project._nav', ['title' => 'Colophon'])
    </div>
@endsection

@section ('content')

<main class="max-w-2xl mx-auto text-gray-700 text-lg page-content" data-style="red">
    <div class="is-layout-flow wp-block-group">
        {!! $body[0]->C14N() !!}
    </div>

    @foreach ($styles as $style)
        {!! $style->C14N() !!}
    @endforeach

    <style>
        .wp-caption.aligncenter {
            margin-left: auto !important;
            margin-right: auto !important;
        }
        .is-layout-constrained > * + * {
            margin-block-start: 1.5rem;
            margin-block-end: 0;
        }
    </style>
</main> 

@endsection