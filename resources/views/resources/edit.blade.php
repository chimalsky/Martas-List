@extends ('layouts.resources.edit')

@section ('content')

<section class="flex flex-wrap mb-8 max-w-6xl">
    {{ html()->modelForm($resource, 'PUT', route('resources.update', $resource))->class('w-full')->open() }}
        @unless(true)
            @livewire('resource.header', ['resource' => $resource])
            @livewire('resource.body', ['resource' => $resource]) 
        @endunless

        @livewire('resource-form', ['resource' => $resource])

        <footer class="py-4">
            <button class="btn bg-indigo-500 shadow-2xl text-white fixed text-2xl bottom-0 mb-8">
                Save changes
            </button>
        </footer>
    {{ html()->closeModelForm() }}
</section>


<section class="my-12">
    @livewire('resource.connections-query', ['resource' => $resource])

    <section class="flex flex-wrap hidden">
        <section class="w-full max-w-3xl">
            @foreach (\App\ResourceType::find($resource->definition->connections->pluck('key')) as $resourceType)
                <header class="m-2 mt-32 w-full flex justify-between">
                    <h1 class="text-xl">
                        {{ $resourceType->name }} Connections
                    </h1>

                    <a href="{{ route('resource.connections.create', ['resource' => $resource, 'connectingResource' => $resourceType]) }}" 
                        class="btn btn-hollow">
                        Add another connected {{ $resourceType->name }}
                    </a>
                </header>

                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th>
                            </th>

                            <th>

                            </th>
                            
                        </tr>
                    </thead>
                    <tbody class="">
                        @foreach ($resource->connections as $connection) 
                            @if (isset($connection->resource) && $connection->resource->definition->is($resourceType))

                                <tr class="hover:cursor-pointer">
                                    <td class="py-2 pl-2">
                                        <a href="{{ route('resources.edit', $connection->resource) }}" class="text-2xl underline">
                                            {{ $connection->resource->name }}
                                        </a>
                                    </td>

                                    <td class="pr-2">
                                        {{ html()->modelForm($resource, 'DELETE', route('resource.connections.destroy', [
                                            'resource' => $resource,
                                            'connection' => $connection
                                        ] ))->open() }}
                                            <div class="flex justify-end mr-4 mt-4">
                                                <button class="btn btn-red">
                                                    Disconnect
                                                </button>
                                            </div>
                                        {{ html()->closeModelForm() }}
                                    </td>

                                
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        </section>
    </section>

<section class="flex flex-wrap my-8 border-4 border-dashed border-gray-300">
    <div class="w-full p-4">
        {{ html()->form('POST', route('resource.media.store', $resource))
            ->acceptsFiles()
            ->open() }}

            @include('resource.media.form')

            <label>
                <input type="checkbox" name="collection" value="secondary" />
                Is Secondary
            </label>

            <footer class="py-4 mt-4">
                <button class="btn btn-hollow">
                    Add media to {{ $resource->name }} 
                </button>
            </footer>
        {{ html()->form()->close() }}
    </div>


    <section class="w-full my-8 flex flex-wrap">
        <h1 class="m-2 w-full font-semibold">
            {{ $resource->name }} has {{ $resource->getMedia()->count() }} media
        </h1>

        @foreach ($resource->getMedia('default') as $medium) 
            <article class="w-full md:w-1/2">
                <div class="border border-1 border-gray-600 p-4">
                    {{ html()->modelForm($medium, 'PUT', route('resource.media.update', 
                        [
                            'resource' => $resource,
                            'medium' => $medium->id
                        ]
                        ))->open()
                    }}
                                                
                        <section class="flex flex-wrap">
                            <label class="w-full my-2">
                                Name
                                {{ html()->text('name')->class(['form-input']) }}
                            </label>
                        </section>

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
                        <img src="{{ $medium->getUrl('thumb') }}" />
                    @elseif (Str::contains($medium->mime_type, 'audio'))
                        <audio
                            controls
                            src="{{ $medium->getUrl() }}">
                                Your browser does not support the
                                <code>audio</code> element.
                        </audio>
                    @else 
                        <a href="{{ $medium->getUrl() }}"" download> download </a>
                    @endif
                </div>
            </article>
        @endforeach

        @foreach ($resource->getMedia('secondary') as $medium) 
            <h1 class="w-full mb-4 font-bold text-red-600 text-2xl">
                Secondary Media
            </h1>
            <article class="w-full md:w-1/2">
                <div class="border border-1 border-gray-600 p-4">
                    {{ html()->modelForm($medium, 'PUT', route('resource.media.update', 
                        [
                            'resource' => $resource,
                            'medium' => $medium->id
                        ]
                        ))->open()
                    }}
                                                
                        <section class="flex flex-wrap">
                            <label class="w-full my-2">
                                Name
                                {{ html()->text('name')->class(['form-input']) }}
                            </label>
                        </section>

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
                        <img src="{{ $medium->getUrl('thumb') }}" />
                    @elseif (Str::contains($medium->mime_type, 'audio'))
                        <audio
                            controls
                            src="{{ $medium->getUrl() }}">
                                Your browser does not support the
                                <code>audio</code> element.
                        </audio>
                    @else 
                        <a href="{{ $medium->getUrl() }}"" download> download </a>
                    @endif
                </div>
            </article>
        @endforeach
    </section>
</section>

</section>

@endsection