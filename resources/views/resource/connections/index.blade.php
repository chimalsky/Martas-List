@extends ('layouts.resources.edit')

@section ('content')

<form action="{{ route('resource.connections.store', $resource) }}" method="post"
    data-controller="resource-types" 
    data-resource-types-search-url="{{ route('resources.index') }}" 
    class="mt-8 bg-red-200 p-4 mb-4">
    @csrf

    <h1 class="m-2 font-semibold">
        Forge connections between {{ $resource->name }} and other resources
    </h1>

    <select name="resource_type_id" data-action="resource-types#select">
        <option>
            Pick a resource type 
        </option> 

        @foreach (App\ResourceType::all() as $type)
            <option value="{{ $type->id }}">
                {{ $type->name }}
            </option>
        @endforeach
    </select>

    <div data-target="resource-types.results" class="my-8 flex flex-wrap">

    </div>

    <button class="btn btn-hollow">
        Forge this resource connection
    </button>
</form>

<section class="flex flex-wrap">
    <h1 class="m-2 w-full font-bold">
        {{ $resource->name }} is connected with {{ $resource->connections->count() }} other resources of 
        {{ $resource->connectedTypes->count() }} varieties
    </h1>

    <section class="w-full max-w-4xl">
        @foreach ($resource->connectedTypes as $resourceType)
            <h1 class="m-2 mt-8 text-xl w-full">
                {{ $resourceType->name }}
            </h1>

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

                            <tr class="w-full border-b border-gray-400 hover:bg-gray-200 hover:cursor-pointer">
                                <td class="py-2 pl-2">
                                    <a href="{{ route('resources.edit', $connection->resource) }}" class="text-blue-600">
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

    

    @foreach ($resource->connectedTypes as $resourceType)
        <h1 class="m-2 mt-8 text-xl w-full">
            {{ $resourceType->name }}
        </h1>

        @foreach ($resource->connections as $connection) 
            @if (isset($connection->resource) && $connection->resource->definition->is($resourceType))
                @include('resource.connections.item', [
                    'resource' => $resource, 
                    'connection' => $connection
                ])
            @endif
        @endforeach
    @endforeach
</section>

@endsection