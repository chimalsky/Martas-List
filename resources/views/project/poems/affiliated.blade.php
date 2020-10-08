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
{{ $firstline }} | 
<a class="text-black underline italic">
    Affiliated Manuscripts
</a>
<span>
    |
</span>
<a href="" class="text-gray-500">
    Commentary
</a>
@endsection

@section ('content')


<section class="block">
    <header class="text-xl text-red-700 block">
        Affiliated Manuscripts --
    </header>

    <main class="flex flex-wrap w-full pt-12">
        @foreach ($poems as $poem)
            <article class="pb-32 px-4 w-full lg:w-1/2 xl:w-1/3s">
                <a href="@route('project.poems.show', $poem)">
                    @php 
                        $imageCount = $poem->getMedia()->count()
                    @endphp

                    <section class="block flex justify-center">
                        
                        <div class="grid gap-8
                            @if ($imageCount == 2)
                                grid-cols-2 w-1/2
                            @elseif ($imageCount == 3)
                                grid-cols-3
                            @elseif ($imageCount == 4)
                                grid-cols-2 w-1/2
                            @elseif ($imageCount == 5)
                                grid-cols-3
                            @endif
                            ">
                            @forelse ($poem->getMedia() as $medium)
                                @if (Str::contains($medium->mime_type, 'image'))
                                    <div class="flex justify-center cursor-pointer">
                                        <img class="w-24 px-1 shadow-lg facs-thumb" 
                                        src="{{ $medium->getUrl('thumb') }}" />
                                    </div>
                                @endif
                            @empty 
                                <div class="flex justify-center cursor-pointer">
                                    <div class="w-24 h-40 border-4 border-gray-300">
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </section>
                </a>

                <div class="text-center mt-4">
                    {{ $firstline }}

                    <p>
                        
                    </p>

                    <p>
                        {{ $poem->firstMetaByAttribute(138)->value ?? null }}
                    </p>
                    <p>
                        {{ $poem->firstMetaByAttribute(131)->value ?? null }}
                    </p>
                    <p>
                        {{ $poem->firstMetaByAttribute(103)->value ?? null }}
                    </p>
                    <p>
                        {{ $poem->firstMetaByAttribute(142)->value ?? null }}
                    </p>
                </div>
            </article> 
        @endforeach
    </main>
</section>


@endsection