@extends ('layouts.project-shifted')

@section('title')
    {{ $bird->name }} - Affiliated Manuscripts - Dickinson's Birds
@endsection

@section('header-anchor')
<a href="@route('project.birds.index')">
    Bird Archive
</a>
@endsection 

@section ('header-info')
    @include('project.birds._header')
@endsection

@section('content')
<section id="poems" class="mt-10 lg:mt-24">
    <h1 style="color: #B45F06;" class="text-3xl font-bold text-center mb-10">
        Dickinson's <span class="italic">{{ Str::plural($bird->category->name) }}</psan>
    </h1>

    <main class="mt-4 flex flex-wrap">
        @foreach ($poems as $poem)
            <article class="w-full md:w-1/2 lg:w-1/3 lg:px-2 pb-10 lg:pb-16">
                @include('project.poems._single', $poem)
            </article>
        @endforeach
    </main>
    
    <x-project.poem.state />
</section>
@endsection
