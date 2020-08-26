@extends ('layouts.project')


@section ('header')
    @include('project.poems._header')
@endsection

@section ('content')
<section class="flex justify-center">
    <main class="max-w-5xl text-gray-700 text-lg">
        <header class="text-center">
            <h1 class="text-4xl font-hairline mb-8 pl-5">
                {{ $firstline }} | 
                @if($poem->category) 
                    <a class="text-black underline italic" href="">
                        Poem Constellation
                    </a>
                @else 
                    <span class="text-gray-500 italic">
                        Poem Constellation
                    </span>
                @endif
            </h1>

            <p class="mt-18 text-black text-lg">
                {{ $season }} {{ $year }}
            </p>

            <p class="text-base text-gray-600">
                {{ $state }}
                <br/>
                {{ $setting }}, {{ $circulation }}
            </p>

            <p class="mt-2 text-gray-600 hidden">

                Copied in 
                {{ $poem->meta->where('resource_attribute_id', 142)->first()->value ?? null }}
                on 
                {{ $poem->meta->where('resource_attribute_id', 87)->first()->value ?? null }},
                bound into
                {{ $poem->meta->where('resource_attribute_id', 3)->first()->value ?? null }}
            </p>

        </header>

        <section class="mt-12 flex flex-wrap">
            <div class="w-1/3 mt-16">
                {!! $poem->meta->where('resource_attribute_id', 78)->first()->value ?? null !!}
            </div>

                <div class="w-2/3 md:pl-4 lg:pl-8">
                    @if ($poem->media()->exists())
                        <livewire:project.media-viewer :resource="$poem" />
                    @endif
                </div>
        </section>


        <section id="birds" class="mt-12 lg:mt-24">
            <h1 class="text-2xl text-orange-700">
                Birds circulating in this MS --
            </h1>
            
            <main class="slick-carousel">
                @foreach ($birds as $bird)
                    <!--<article class="w-full lg:w-1/3 lg:px-2 pb-10 lg:pb-16 border-2 border-gray-400 shadow-lg rounded-lg">-->
                    <div class="p-4 container">
                        <a href="@route('project.birds.show', $bird)">
                            <article class="bird border-2 border-gray-400  shadow-lg hover:shadow-2xl rounded-lg pt-2 pb-6 px-4">
                                @include('project.birds._single', $bird)
                            </article>
                        </a>
                    </div>
                @endforeach
            </main>
        </section>

    </main>
</section>

@endsection