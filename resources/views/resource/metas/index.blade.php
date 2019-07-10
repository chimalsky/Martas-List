@extends ('layouts.web')

@section ('content')

<header class="flex align-left mb-8">

    <p class="ml-4 font-bold"> 
        {{ $resource->definition->name }} -- {{ $resource->name }} 
    </p>
</header>

<nav class="w-full flex align-left">
    <a href="">
        Tags
    </a>
    <a href="{{ route('resource.connections.index', ['resource' => $resource]) }}">
        Connections
    </a>
    <a href="">
        Media
    </a>
</nav>

<form action="{{ route('resource.metas.store', $resource) }}" method="post"
    class="mt-8 bg-gray-300 p-4 mb-4">
    @csrf

    <h1 class="m-2 font-semibold">
        Add new tag 
    </h1>

    @include('encodings.meta.form')

    <button class="btn btn-blue">
        Add this tag to {{ $resource->name }}
    </button>
</form>


<section class="flex flex-wrap">
    <h1 class="m-2 text-2xl w-full">
        @if ($resource->meta->count())
            {{ $resource->name }} Tags
        @else 
            Add Some Tags to {{ $resource->name }} !
        @endif
    </h1>

    @foreach ($resource->meta->reverse() as $meta)
        <article class="w-full md:w-1/2 lg:w-1/3 border border-1 border-gray-400 mb-4 py-4">
            {{ html()->modelForm($meta, 'PUT', route('resource.metas.update', [
                'resource' => $resource, 
                'meta' => $meta
            ] ))->open() }}
                
                @include('encodings.meta.item', ['meta' => $meta])

            {{ html()->closeModelForm() }}

            {{ html()->modelForm($meta, 'DELETE', route('resource.metas.destroy', [
                'resource' => $resource, 
                'meta' => $meta
            ] ))->open() }}
                <div class="flex justify-end mr-4 mt-4">
                    <button class="btn btn-red">
                        Delete
                    </button>
                </div>
            {{ html()->closeModelForm() }}
        </article>
    @endforeach
</section>


@endsection