@extends ('layouts.project')


@section ('header')
    <header class="">
        @include('project.poems._header')
    </header>
@endsection

@section ('content')
<section class="flex justify-center">
    <main class="max-w-5xl text-gray-700 text-lg">
        <header class="text-center">
            <h1 class="text-4xl font-hairline mb-8 pl-5">
                {{ $poems->first()->name }} | 
                <a class="text-black underline italic">
                    Affiliated Manuscripts
                </a>
            </h1>
        </header>
    </main>
</section>

<section class="container mx-auto">
    <header class="text-xl text-red-700">
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
                                        <img class="w-24 px-1 shadow-lg" 
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
                    {{ $poem->name }}

                    <p>
                        {{ $poem->firstMetaByAttribute(138)->value }}
                    </p>
                    <p>
                        {{ $poem->firstMetaByAttribute(131)->value }}
                    </p>
                    <p>
                        {{ $poem->firstMetaByAttribute(103)->value }}
                    </p>
                    <p>
                        {{ $poem->firstMetaByAttribute(142)->value }}
                    </p>
                </div>
            </article> 
        @endforeach
    </main>
</section>

@endsection