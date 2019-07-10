@extends ('layouts.web')

@section ('content')

<header class="flex align-left mb-8">
    <a class="btn btn-gray font-thin" href="{{ route('resource-types.edit', $resource->definition) }}">
        Return to {{ $resource->definition->name }} Page
    </a> 

    <p class="ml-4 font-bold"> 
        {{ $resource->definition->name }} -- {{ $resource->name }} 
    </p>
</header>

<nav class="w-full flex align-left">
    <a href="{{ route('resource.metas.index', ['resource' => $resource]) }}">
        Tags
    </a>
    <a href="{{ route('resource.connections.index', ['resource' => $resource]) }}">
        Connections
    </a>
    <a href="{{ route('resource.media.index', ['resource' => $resource]) }}">
        Media
    </a>
</nav>

<main>
    @yield('asdf')
</main>



@endsection