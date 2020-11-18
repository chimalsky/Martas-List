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
<a class="text-black underline">
    Affiliated Manuscripts
</a>
<span>
    |
</span>
<a href="@route('project.poems.commentary', $poem)" class="text-gray-500">
    Commentary
</a>

<x-project.poem.state />

<x-project.archive-notes contentId="42072">
</x-project.archive-notes>
@endsection

@section ('content')


<section class="block">
    <header class="text-xl text-red-700 block">
        Affiliated Manuscripts --
    </header>

    <main class="flex flex-wrap w-full pt-12">
        @foreach ($poems as $poem)
            <article class="pb-32 px-4 w-full lg:w-1/2 xl:w-1/3">
                <a href="@route('project.poems.show', $poem)">
                    <x-project.poem.image :poem="$poem" />
                </a>

                <div class="text-center mt-4">
                    <header class="font-bold mb-1">
                        {{ $firstline }}
                    </header>

                    @foreach ($poem->metaByAttribute(597)->pluck('value') as $line)
                        <p>
                            {{ $line }}
                        </p>
                    @endforeach
                </div>
            </article> 
        @endforeach
    </main>
</section>


@endsection