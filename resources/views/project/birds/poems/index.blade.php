@extends ('layouts.project-shifted')


@section('header-anchor')
<a href="@route('project.birds.index')" class=''>
    <div>
        <span class="text-4xl">B</span>IRD 

        <span class="text-4xl">A</span>RCHIVE
    </div>
</a>
@endsection 

@section ('header-info')
    @include('project.birds._header')

    @php 
        $xc_citation = $bird->metaByAttribute(502)->first()->value;
        $url = Str::afterLast($xc_citation, ' ');
        $url = Str::beforeLast($url, '.');
        $url = 'https://'.trim($url);
    @endphp

    <section class="flex justify-center mt-2">
        <iframe src='{{ $url }}/embed' scrolling='no' frameborder='0' width='340' height='220'></iframe>
    </section>
@endsection

@section('content')
<section id="poems" class="mt-12 lg:mt-24">
    <h1 style="color: #B45F06;" class="text-2xl text-center">
        Dickinson's <span class="italic">{{ Str::plural($bird->category->name) }}</psan>
    </h1>
    
    <main class="mt-4 flex flex-wrap">
        @foreach ($poems as $poem)
            <article class="w-full md:w-1/2 lg:w-1/3 lg:px-2 pb-10 lg:pb-16">
                @include('project.poems._single', $poem)
            </article>
        @endforeach
    </main>
</section>
@endsection
