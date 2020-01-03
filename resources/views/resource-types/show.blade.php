@extends ('resource-type._layout')

@section ('content')

<header class="mb-8 max-w-4xl">
    <div class="my-4 block">
       {!! $resourceType->description !!}
    </div>
</header>

<section class="bg-gray-100 max-w-4xl py-2 px-4">
    @if($resourceType->resources->count())
        <section class="my-2 float-right">
            <p class="inline-block mr-2">
                <strong>
                    {{ $resourceType->resources()->count() }}
                </strong>
                Resources
            </p>
            <a href="{{ route('resource-type.resources.create', $resourceType) }}"
                class="inline-block btn btn-blue">
                Add New {{ $resourceType->nameSingular }}
            </a>
        </section>

        <section class="">
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
                    @foreach($resourceType->resources as $resource)
                        <tr class="w-full border-b border-gray-400 hover:bg-gray-200 hover:cursor-pointer">
                            <td class="py-2 pl-2">
                                <a href="{{ route('resources.edit', $resource) }}" class="text-blue-600">
                                    {{ $resource->name }}
                                </a>
                            </td>

                            <td>
                                @foreach ($resource->resourcesGrouped as $key => $group)
                                    <div class="text-sm">
                                        {{ $key }} Connections

                                        {{ $group->count() }}
                                    </div>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach 
                </tbody>
            </table>
        </section>
    @else 
        <h1 class="text-xl">
            No {{ $resourceType->name }} yet...  
        </h1>
    @endif

</section>

@endsection