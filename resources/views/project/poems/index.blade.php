@extends ('layouts.project')


@section ('header')
    <header class="">
        @include('project.poems._header')
    </header>
@endsection

@section ('content')

    <livewire:project.poems-index />

@endsection