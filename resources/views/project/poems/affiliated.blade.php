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
<a href="" class="text-gray-500">
    Commentary
</a>

<section class="flex justify-center space-x-4 max-w-md mx-auto mt-8 text-sm">
    <div class="inline-block">
        <img class="w-8 inline-block" src="{{ asset('img/lost-or-destroyed.png') }}" />
        <span>
            = manuscript lost or destroyed
        </span>
    </div>

    <div class="inline-block">
        <img class="w-6 inline-block" src="{{ asset('img/coming-soon.jpg') }}" />
        <span>
            = manuscript coming soon
        </span>
    </div>
</section>

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
                    <header class="font-bold">
                        {{ $firstline }}
                    </header>

                    <p>
                        <!-- year of composition -->
                        {{ optional($poem->firstMetaByAttribute(138))->value }},
                        <!-- season of composition -->
                        {{ optional($poem->firstMetaByAttribute(131))->value }}
                    </p>
                    <p>
                        <!-- medium -->
                        {{ optional($poem->firstMetaByAttribute(142))->value }}.
                        <!-- mnuscript state --> 
                        {{ optional($poem->firstMetaByAttribute(89))->value }}.
                    </p>
                    <p>
                        <!-- setting -->
                        {{ optional($poem->firstMetaByAttribute(103))->value }}
                        <!-- ciculation -->
                        {{ optional($poem->firstMetaByAttribute(113))->value }}
                    </p>
                </div>
            </article> 
        @endforeach
    </main>
</section>


@endsection