@extends ('layouts.project-shifted')


@section('header-anchor')
<a href="@route('project.poems.index')">
    Poem Archive
</a>
@endsection 


@section('header-info')
<a href="@route('project.poems.show', $poem)">
    {{ $firstline }} 
</a> | 
@if($poem->category) 
    <a class="" href="@route('project.affiliated.poems', $poem)">
        Affiliated Manuscripts
    </a>
@else 
    <span class="text-gray-500">
        Affiliated Manuscripts
    </span>
@endif
<span>
    |
</span>
<a href="" class="text-gray-500 underline">
    Commentary
</a>
@endsection

@section ('content')

<main class="relative ml-48 mt-10">
    <img src="{{ asset('img/bird-notebook.png') }}" />
    <section class="absolute inset-0 flex flex-wrap py-32 pr-48 pl-48">
        <div class="w-2/5 pr-18 overflow-auto" style="max-height: 80%;">
            <div class="text-2xl">
                Commentary coming 2021-2022.
            </div>
        </div>


        <div class="w-3/5 h-auto pl-32 pr-8 overflow-hidden" style="max-height: 80%;">
            <img src="{{ asset('img/owl.jpg') }}" class="object-contain" />
        </div>
    </section>

    <aside class="text-center mt-12">
        <i>"Snowy Owl"</i>, painting by Mabel Loomis Todd
    </aside>
</main>

@endsection