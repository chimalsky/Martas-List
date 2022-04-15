@extends ('layouts.project-shifted')

@section('title')
    {{ $bird->name }} - Dickinson's Birds
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


@auth
    <div class="flex justify-center my-4">
        <a href="{{ route('resources.edit', $bird) }}" class="no-underline border border-gray-500 p-2 hover:underline font-normal text-teal-800">
            View/Edit Data 
        </a>
    </div>
@endauth

@php
    $nineteenthBird = $bird->resources->firstWhere('resource_type_id', 8);
    $nineteenthBirdAlt = $bird->resources->firstWhere('resource_type_id', 12);
    
    $twentiethBird = $bird->resources->firstWhere('resource_type_id', 14);
    $twentyfirstBird = $bird->resources->firstWhere('resource_type_id', 15);
    $migrationMapLink = $bird->firstMetaByAttribute(506);
@endphp

<main class="text-center max-w-sm mx-auto">
    <x-project.bird.notebook.entry header="Occurrence in Amherst & Connecticut Valley, Mass.">
        <x-project.bird.presence class="mb-4" century="19" :bird="$nineteenthBird" :primaryBird="$bird" />

        <x-project.bird.presence class="mb-4" century="20" :bird="$twentiethBird" :primaryBird="$bird" />
        
        <x-project.bird.presence class="mb-4" century="21" :bird="$twentyfirstBird" :primaryBird="$bird" />
    </x-project.bird.notebook.entry>

    <x-project.bird.notebook.entry header="Habitat" class="text-lg" :data="$bird->firstMetaByAttribute(504)" />

    <x-project.bird.notebook.entry header="Nest Materials" class="text-lg" :data="$bird->firstMetaByAttribute(505)" />

    @if ($birdCategory)
        @php 
            $fieldNotes = $nineteenthBird  
                ? $nineteenthBird->firstMetaByAttribute(590)
                : null;
        @endphp
        @if ($fieldNotes)
        <x-project.bird.notebook.entry header="19th-20th Century Field Notes" class="text-lg" :noSmallCaps="true" :data="$fieldNotes">
            <p class="text-right">
                —H.L. Clark, 1887
            </p>
        </x-project.bird.notebook.entry>
        @endif
    @endif

    <x-project.bird.notebook.entry header="21st Century Conservation Notes" :noSmallCaps="true" :data="$bird->firstMetaByAttribute(37)">
        <p class="text-lg">
            {{ optional($bird->firstMetaByAttribute(596))->value.'*' ?? 'Information Coming Soon' }}
        </p>
    </x-project.bird.notebook.entry>
</main>
@endsection

@section('after-content-stretch')
<section class="flex justify-center my-12">
    @foreach ($bird->getMedia() as $sonogram)
        @if (Str::contains($sonogram->mime_type, 'image'))
            <img class="block" src="{{ $sonogram->getUrl() }}" />
        @endif
    @endforeach 
</section>
@endsection
