
@foreach ($resource->connectedTypes as $resourceType)
    <h1 class="mt-4 w-full text-xs">
        {{ $resourceType->name }}
    </h1>

    @foreach ($resource->connections as $connection) 
    <ul>
        @if (isset($connection->resource) && $connection->resource->definition->is($resourceType))
            <li>
                <a href="{{ route('resources.edit', $connection->resource) }}">
                    {{ $connection->resource->name }}
                </a>
            </li>
        @endif
    </ul>
    @endforeach
@endforeach