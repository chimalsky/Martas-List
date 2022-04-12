@extends ('layouts.project')


@section('title')
    About the Project - Dickinson's Birds
@endsection

@php
    $header = true;
@endphp
@section ('header')
    <div class="mt-8 max-w-2xl mx-auto">
        @include('project._nav', ['title' => 'About the Project'])
    </div>
@endsection

@section ('content')

<main class="max-w-2xl mx-auto text-gray-700 text-lg page-content" data-style="red">
    {!! $content !!}
</main> 

@endsection