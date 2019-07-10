<a class="w-full md:w-1/2 lg:w-1/3 p-2"
href="{{ route('resources.edit', $resource) }}">
    <div class="m4 p-4 border border-2 border-gray-900">
        {{ $resource->name }}

        {{ html()->modelForm($resource, 'DELETE', route('resource.connections.destroy', [
            'encoding' => $encoding,
            'resource' => $resource, 
        ] ))->open() }}
            <div class="flex justify-end mr-4 mt-4">
                <button class="btn btn-red">
                    Remove this connection
                </button>
            </div>
        {{ html()->closeModelForm() }}
    </div>
</a>
