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

<section class="flex flex-wrap mb-8">
    {{ html()->modelForm($resource, 'PUT', route('resources.update', $resource))->open() }}
        @include('resources.form')

        <footer class="py-4">
            <button class="btn btn-hollow">
                Save the changed name 
            </button>
        </footer>
    {{ html()->closeModelForm() }}

    <div class="w-full bg-red-200 p-4">
        {{ html()->form('POST', route('resource.media.store', $resource))
            ->acceptsFiles()
            ->open() }}

            @include('resources.media.form')

            <footer class="py-4">
                <button class="btn btn-hollow">
                    Add media to {{ $resource->name }} 
                </button>
            </footer>
        {{ html()->form()->close() }}
    </div>
</section>




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

<section class="flex flex-wrap">
    <h1 class="m-2 text-2xl w-full">
        {{ $resource->name }} is attached to {{ $resource->encodings->count() }} encodings
    </h1>

    @foreach ($resource->encodings as $encoding) 
        @include('encodings.item', ['encoding' => $encoding])
    @endforeach
</section>


<section class="flex flex-wrap">
    <h1 class="m-2 text-2xl w-full">
        {{ $resource->name }} has {{ $resource->getMedia()->count() }} media
    </h1>

    @foreach ($resource->getMedia() as $media)
        <article class="w-full md:w-1/2">
            <p> {{ $media->name }} </p>

            @if (Str::contains($media->mime_type, 'image'))
                <img src="{{ $media->getUrl() }}" />
            @elseif (Str::contains($media->mime_type, 'audio'))
                <audio
                    controls
                    src="{{ $media->getUrl() }}">
                        Your browser does not support the
                        <code>audio</code> element.
                </audio>
            @endif
        </article>
    @endforeach

</section>

@endsection