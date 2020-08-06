@extends ('layouts.project')


@section ('header')
    @include('project.poems._header')
@endsection

@section ('content')

<livewire:project.poems-index />

@endsection