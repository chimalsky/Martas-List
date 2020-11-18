@extends ('layouts.project-shifted')


@section('header-anchor')
<a href="@route('project.poems.index')" class=''>
    <div>
        <span class="text-4xl">P</span>OEM 

        <span class="text-4xl">A</span>RCHIVE
    </div>
</a>
@endsection 


@section('header-info')
<span style="color:#B45F06">
    {{ $firstline }} 
</span> | 
@if($poem->category) 
    <a class="text-black" href="@route('project.affiliated.poems', $poem)">
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


        <div class="w-3/5 pl-32 pr-8 overflow-auto" style="max-height: 80%;">
        </div>
    </section>
</main>

@endsection