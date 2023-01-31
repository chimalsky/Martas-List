@extends ('layouts.project')

@section('title')
    About: Navigation - Dickinson's Birds
@endsection

@php
    $header = true;
@endphp
@section ('header')
    <div class="mt-8 max-w-2xl mx-auto">
        @include('project._nav', ['title' => 'About: Navigation'])
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
        .is-layout-constrained > .alignleft {
            float: left;
            margin-inline-start: 0;
            margin-inline-end: 2em;
        }
    </style>
</main> 

@endsection