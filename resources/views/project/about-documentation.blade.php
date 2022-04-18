@extends ('layouts.project')

@section('title')
    Project Documentation and Related Writings - Dickinson's Birds
@endsection

@php
    $header = true;
@endphp
@section ('header')
    <div class="mt-8 max-w-2xl mx-auto">
        @include('project._nav', ['title' => 'Project Documentation and Related Writings'])
    </div>
@endsection

@section ('content')

<main class="max-w-2xl mx-auto text-gray-700 text-lg page-content" data-style="red">
    {!! optional(App\ResourceMeta::find(59409))->value ?? 'No content yet' !!}
</main> 

@endsection