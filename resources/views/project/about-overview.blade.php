@extends ('layouts.project')

@section('title')
    About: Overview - Dickinson's Birds
@endsection

@php
    $header = true;
@endphp
@section ('header')
    <div class="mt-8 max-w-2xl mx-auto">
        @include('project._nav', ['title' => 'About: Overview'])
    </div>
@endsection

@section ('content')

@include('project._about-subheader')

<main class="max-w-2xl mx-auto text-gray-700 text-lg page-content" data-style="red">
    {!! optional(App\ResourceMeta::find(59408))->value ?? 'No content yet' !!}
</main> 

@endsection