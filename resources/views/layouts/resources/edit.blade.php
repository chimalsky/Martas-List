@extends ('layouts.web')

@section ('header')

<section class="web container mx-auto">
    <header class="flex align-left mb-8">
        <a href="{{ route('resource-types.index') }}">
            Resources
        </a>

        <span class="mx-4">
            >
        </span>

        <a href="{{ route('resource-types.show', $resource->definition) }}" class="mx-2">
            {{ $resource->definition->name }}
        </a>
        
        <span class="mx-4">
            >
        </span>

        <p class="mx-2 font-bold underline"> 
            {{ $resource->name }} 
        </p>
    </header>

    <nav class="w-full flex align-left border border-1 border-gray-500 mb-4">
        <a href="{{ route('resources.edit', ['resource' => $resource]) }}"
            class="p-2 mx-2 
            {{ (request()->is('resources/*')) ? 'bg-gray-700 text-gray-100' : '' }}
            ">
            Attributes
        </a>

        <a href="{{ route('resource.connections.index', ['resource' => $resource]) }}"
            class="p-2 mx-2
            {{ (request()->is('resource/*/connections*')) ? 'bg-gray-700 text-gray-100' : '' }}
            ">
            Connections
        </a>

        <a href="{{ route('resource.lineages.index', ['resource' => $resource]) }}"
            class="p-2 mx-2 hidden
            {{ (request()->is('resource/*/lineages*')) ? 'bg-gray-700 text-gray-100' : '' }}
            ">
            Lineages
        </a>

        <a href="{{ route('resource.media.index', ['resource' => $resource]) }}"
            class="p-2 mx-2 hidden 
            {{ (request()->is('resource/*/media*')) ? 'bg-gray-700 text-gray-100' : '' }}
            ">
            Media
        </a>

        <a href="{{ route('resource.temporalities.index', ['resource' => $resource]) }}"
            class="p-2 mx-2 hidden
            {{ (request()->is('resource/*/temporalities*')) ? 'bg-gray-700 text-gray-100' : '' }}
            ">
            Temporalities
        </a>

        {{ html()->form('DELETE', route('resources.destroy', $resource))->open() }}
            <section data-controller="form">
                <button class="btn bg-red-500 text-white delete" data-action="form#delete">
                    Delete
                </button>
            </section>
        {{ html()->form()->close() }}
    </nav>
</section>

@endsection