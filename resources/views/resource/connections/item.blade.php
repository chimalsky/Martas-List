<article class="w-full md:w-1/2 lg:w-1/3 p-2">
    <main class="m4 p-4 border border-2 border-gray-900">
        <a href="{{ route('resources.edit', $connection->resource) }}">
            {{ $connection->resource->name }}
        </a>

        <aside class="w-full mt-2">
            <div class="italic">
                {!! $resource->excerpt !!}
            </div>
            
            <section class="bg-gray-200 p-2">
                @include('resource.connections.panel', ['resource' => $connection->resource])
            </section>
        </aside>
        
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
    </main>
</article>
