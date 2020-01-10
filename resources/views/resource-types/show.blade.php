@extends ('resource-type._layout')

@section ('content')

<header class="mb-8 max-w-4xl">
    <div class="my-4 block">
       {!! $resourceType->description !!}
    </div>
</header>

<section class="bg-gray-100 py-2 px-4">
    @if($resourceType->resources->count())
        <section class="my-2 max-w-5xl flex justify-between">
            <div>
                <form action="@route('resource-types.show', $resourceType)" method="get">
                    @foreach ($resourceType->attributes as $attribute)
                        <label class="block">
                            <input type="checkbox" 
                                name="attribute[{{ $attribute->id }}]" 
                                @if ($enabledAttributes->contains($attribute->id))
                                    checked
                                @endif
                                /> 
                                {{ $attribute->key }}
                        </label>
                    @endforeach

                    <footer class="block mt-4">
                        <button class="btn btn-hollow ">
                            Filter
                        </button>
                    </footer>
                </form>
            </div>

            <div>
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
            </div>
        </section>

        <section class="mt-8">
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th class="text-left">
                            Resource Name
                        </th>
                        
                        @foreach($enabledAttributes as $key)
                            <th>
                                {{ $resourceType->attributes->firstWhere('id', $key)->name }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="">
                    @foreach ($resourceType->resources as $resource)
                        <tr class="w-full border-b border-gray-400 hover:bg-gray-200 hover:cursor-pointer">
                            <td class="py-2 pl-2">
                                <a href="{{ route('resources.edit', $resource) }}" class="text-blue-600">
                                    {{ $resource->name }}
                                </a>
                            </td>

                            @foreach ($resource->meta->whereIn('resource_attribute_id', $enabledAttributes) as $enabledAttribute)
                                <td>
                                    {{ $enabledAttribute->value }}
                                </td>
                            @endforeach
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