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
<x-project.archive-notes>
    <article>
        +  For information on the guiding editorial principles for the Poem Archive, see 
        <a href="">
            Introduction.
        </a>
    </article>
    <article>
        +  For details about sources, see 
        <a href="">
            Primary Sources.
        </a>
    </article>

    <h1>
        Sources
    </h1>
    <h2 class="italic">
        Citations for Dickinson’s birds come from— 
    </h2>
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