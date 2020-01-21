@extends ('resource-type._layout')

@section ('content')

<header class="mb-8 max-w-4xl">
    <div class="my-4 block">
       {!! $resourceType->description !!}
    </div>
</header>

<section class="py-2">
    @if($resourceType->resources()->count())
        <section class="block flex justify-between max-w-5xl bg-gray-200 px-2 py-4">
            <section class="inline-block">
                <div x-data="{ open: false}">
                    <button @click="open = true" class="btn btn-hollow">
                        <span x-show="!open">
                            Open Filtering Options
                        </span>

                        <span x-show="open">
                            Close Filtering Options 
                        </span>
                    </button>

                    <form action="@route('resource-types.show', $resourceType)" method="get"
                        x-show="open"
                        @click.away="open = false"
                        class="mt-4">
                        @foreach ($resourceType->attributes as $attribute)
                            <div class="block mb-2"
                                x-data="{filterToggle: false }">
                                <label class="inline-block">
                                    <input type="checkbox" 
                                        name="attribute[{{ $attribute->id }}]" 
                                        @if ($enabledAttributes->contains($attribute->id))
                                            checked
                                        @endif
                                        x-click="filterToggle = true"
                                        /> 
                                        {{ $attribute->key }}
                                </label>

                                
                            </div>
                        @endforeach

                        <footer class="block mt-4">
                            <button class="btn btn-blue">
                                Filter
                            </button>
                        </footer>
                    </form>
                </div>
            </section>

            <nav class="inline-block">
            </nav>
        </section>

        <section class="mt-8">
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th class="text-left">
                            <a href="@route('resource-types.show', array_merge($_GET, 
                                    [
                                    $resourceType, 
                                    'reverse' => !Request::query('reverse'),
                                    'sortMeta' => false
                                    ]))">
                                    Resource Name
                                </a>
                        </th>
                        
                        @foreach($enabledAttributes as $key)
                            <th>
                                <a href="@route('resource-types.show', array_merge($_GET, 
                                    [
                                    $resourceType, 
                                    'reverse' => !Request::query('reverse'),
                                    'sortMeta' => $key
                                    ]))">
                                    {{ $resourceType->attributes->firstWhere('id', $key)->name }}
                                </a>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="">
                    @foreach ($resources as $resource) 
                        <tr class="w-full border-b border-gray-400 hover:bg-gray-300 hover:cursor-pointer
                            @if ($loop->even) bg-gray-100 @endif
                        ">
                            <td class="py-2 pl-2">
                                <a href="{{ route('resources.edit', $resource) }}" class="text-blue-600">
                                    {{ $resource->name }}
                                </a>
                            </td>

                            @foreach ($enabledAttributes as $attributeId)
                                <td>
                                    @if ($resource->meta->where('resource_attribute_id', $attributeId)->first()->value ?? false) 
                                        @foreach ($resource->meta->where('resource_attribute_id', $attributeId) as $attribute)
                                            <div class="@if ($loop->even) pt-2 pb-6 @endif">
                                                {{ $attribute->value }}
                                            </div>
                                        @endforeach
                                    @endif
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