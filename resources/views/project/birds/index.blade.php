@extends ('layouts.project-shifted')

@section('header-anchor')
<a href="@route('project.birds.index')">
    Bird Archive
</a>
@endsection 

@section('header-info')

<x-project.archive-notes title="Bird" contentId="42073">
</x-project.archive-notes>

@endsection

@section('sticky-aside')
<livewire:project.bird.filter />
@endsection

@section ('content')

<div>
    <livewire:project.bird.index />
</div>


@endsection