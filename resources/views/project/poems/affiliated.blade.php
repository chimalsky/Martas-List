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
<a class="font-bold" style="color: #B45F06;">
    Affiliated Manuscripts
</a>
<span>
    |
</span>
<a href="@route('project.poems.commentary', $poem)" class="text-gray-500 italic">
    Commentary
</a>
    
<x-project.poem.state />


<x-project.archive-notes title="Poem">
    <x-slot name="content">
        @php
            $content = optional(App\ResourceMeta::find(42072))->value ?? 'No content yet';
        @endphp

        {!! $content !!}
    </x-slot>
</x-project.archive-notes>
@endsection

@section ('content')


<section class="block">
    <h1 style="color: #B45F06;" class="text-3xl font-bold mt-12 mb-10">
        Affiliated Manuscripts --
    </h1>

    <main class="flex flex-wrap w-full pt-12">
        @foreach ($poems as $poem)
            <article class="pb-32 px-4 w-full lg:w-1/2 xl:w-1/3">
                <a href="@route('project.poems.show', $poem)">
                    <x-project.poem.image :poem="$poem" />
                </a>

                <div class="mt-4 flex justify-center">
                    <div class="w-2/3 text-left">
                        <header class="text-black mb-2" style="font-family: Cormorant Upright;">
                            {{ $poem->firstMetaByAttribute(84)->value }}
                        </header>

                        @foreach ($poem->metaByAttribute(597)->pluck('value') as $line)
                            <p style="font-family: Cormorant">
                                {{ $line }}
                            </p>
                        @endforeach
                    </div>
                </div>
            </article> 
        @endforeach
    </main>
</section>


@endsection