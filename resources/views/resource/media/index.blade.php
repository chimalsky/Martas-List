@extends ('layouts.resources.edit')

@section ('content')


<section class="flex flex-wrap mb-8">
    <div class="w-full bg-red-200 p-4">
        {{ html()->form('POST', route('resource.media.store', $resource))
            ->acceptsFiles()
            ->open() }}

            @include('resource.media.form')

            <footer class="py-4">
                <button class="btn btn-hollow">
                    Add media to {{ $resource->name }} 
                </button>
            </footer>
        {{ html()->form()->close() }}
    </div>
</section>

<section class="flex flex-wrap">
    <h1 class="m-2 w-full font-semibold">
        {{ $resource->name }} has {{ $resource->getMedia()->count() }} media
    </h1>

    @foreach ($resource->getMedia() as $medium)
        <article class="w-full md:w-1/2 lg:w-1/3 p-2">
            <div class="border border-1 border-gray-600 p-4">
                {{ html()->modelForm($medium, 'PUT', route('resource.media.update', 
                    [
                        'resource' => $resource,
                        'medium' => $medium
                    ]
                    ))->open()
                }}
                    <label class="w-full"> 
                        {{ html()->text('name')->class(['form-input']) }}
                    </label>

                    <button class="btn btn-hollow">
                        Save Changes
                    </button>

                {{ html()->closeModelForm() }}

                {{ html()->modelForm($medium, 'DELETE', route('resource.media.destroy', [
                    'resource' => $resource, 
                    'medium' => $medium
                ] ))->open() }}
                    <div class="flex mr-4 my-6">
                        <button class="btn btn-red">
                            Delete
                        </button>
                    </div>
                {{ html()->closeModelForm() }}

                

                @if (Str::contains($medium->mime_type, 'image'))
                    <img src="{{ $medium->getUrl() }}" />
                @elseif (Str::contains($medium->mime_type, 'audio'))
                    <audio
                        controls
                        src="{{ $medium->getUrl() }}">
                            Your browser does not support the
                            <code>audio</code> element.
                    </audio>
                @else 
                    <a href="{{ $medium->getUrl() }}"" download>
                @endif
            </div>
        </article>
    @endforeach

</section>



@endsection