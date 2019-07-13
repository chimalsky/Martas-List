@extends ('layouts.web')

@section ('header')

<section class="web container mx-auto">
    <header class="flex align-left mb-8">
        <a href="{{ route('resources.index') }}">
            Archiver Main Page
        </a>

        <span class="mx-4">
            >
        </span>

        <a href="{{ route('resource-types.index') }}">
            Resources
        </a>

        <span class="mx-4">
            >
        </span>

        <a href="{{ route('resource-types.edit', $resource->definition) }}" class="mx-2">
            {{ $resource->definition->name }}
        </a>
        
        <span class="mx-4">
            >
        </span>

        <a href="{{ route('resources.edit', $resource) }}" class="mx-2 font-bold underline"> 
            {{ $resource->name }} 
        </a>
    </header>

    <nav class="w-full flex align-left border border-1 border-gray-500 mb-4">
        <a href="{{ route('resources.edit', ['resource' => $resource]) }}"
            class="p-2 mx-2 
            {{ (request()->is('resources/*')) ? 'bg-gray-700 text-gray-100' : '' }}
            ">
            Main
        </a>
        <a href="{{ route('resource.metas.index', ['resource' => $resource]) }}"
            class="p-2 mx-2 
            {{ (request()->is('resource/*/metas*')) ? 'bg-gray-700 text-gray-100' : '' }}
            ">
            Tags
        </a>
        <a href="{{ route('resource.connections.index', ['resource' => $resource]) }}"
            class="p-2 mr-2
            {{ (request()->is('resource/*/connections*')) ? 'bg-gray-700 text-gray-100' : '' }}
            ">
            Connections
        </a>
        <a href="{{ route('resource.media.index', ['resource' => $resource]) }}"
            class="p-2 mr-2
            {{ (request()->is('resource/*/media*')) ? 'bg-gray-700 text-gray-100' : '' }}
            ">
            Media
        </a>
    </nav>
</section>

@endsection