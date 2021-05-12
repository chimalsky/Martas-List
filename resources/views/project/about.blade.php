@extends ('layouts.project')


@section('title')
    About the Project - Dickinson's Birds
@endsection

@section ('header')
    @include('project._nav', ['title' => 'About the Project'])
@endsection

@section ('content')

<main class="max-w-2xl mx-auto text-gray-700 text-lg page-content" data-style="red">
    {!! $content !!}
</main> 

@endsection