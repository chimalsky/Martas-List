@extends ('layouts.project-shifted')

@section('header-anchor')
<a href="@route('project.birds.index')" class=''>
    <div>
        <span class="text-4xl">B</span>IRD 

        <span class="text-4xl">A</span>RCHIVE
    </div>
</a>
@endsection 

@section('header-info')

<x-project.archive-notes contentId="42073">
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