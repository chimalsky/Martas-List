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

<section class="flex flex-wrap mb-8">
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