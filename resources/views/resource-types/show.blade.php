@extends ('resource-type._layout')

@section ('content')

<header class="mb-8 max-w-4xl">
    <div class="my-4 block">
       {!! $resourceType->description !!}
    </div>
</header>

<section class="py-2">
    @if($resourceType->resources()->count())
        <section class="block flex justify-between max-w-5xl px-2 py-4">
            <section class="inline-block">
                <div x-data="{ open: false}">
                    <button @click="open = true" x-show="!open" class="btn btn-hollow">
                        Open Filtering Options
                    </button>

                    <button @click="open = false" x-show="open" class="btn btn-hollow">
                        Close Filtering Options
                    </button>

                    <form action="@route('resource-types.show', $resourceType)" method="get"
                        x-show="open"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-90"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-90"
                        class="mt-4 bg-gray-200 p-4 text-lg">
                        @foreach ($resourceType->attributes as $attribute)
                            <div class="block mb-2"
                                x-data="{filterToggle: false}" x-init="filterToggle = $refs.attribute.checked">
                                <label class="inline-block cursor-pointer hover:underline"
                                    @click="filterToggle = $refs.attribute.checked">
                                    <input type="checkbox" 
                                        x-ref="attribute"
                                        name="attribute[{{ $attribute->id }}]" 
                                        @if ($enabledAttributes->contains($attribute->id))
                                            checked
                                        @endif
                                        /> 
                                        {{ $attribute->key }}
                                </label>

                                @if ($attribute->options)
                                    <div class="flex flex-wrap pl-8 pt-2">
                                        @foreach ($attribute->options as $attributeOption)
                                            <label x-show="filterToggle" 
                                                class="mr-6 mb-2 cursor-pointer hover:underline">
                                                <input type="checkbox" 
                                                    name="attributeOption[{{ $attribute->id }}][{{ $attributeOption }}]" 
                                                    @if ($filteredAttributeOptions->keys()->contains($attribute->id))
                                                        @if (collect($filteredAttributeOptions[$attribute->id])->keys()->contains($attributeOption))
                                                            checked
                                                        @endif
                                                    @endif
                                                    />
                                                {{ $attributeOption }}
                                            </label>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach

                        <footer class="block mt-4">
                            <button class="btn btn-blue py-3 px-10">
                                Filter
                            </button>
                        </footer>
                    </form>
                </div>
            </section>
        </section>

        <section class="mt-8">
            @if ($resources->count())
                <header class="block text-right mb-8">
                    <span class="font-bold">
                        {{ $resources->total() }}
                    </span> {{ $resourceType->name }} matches your filters

                    <section class="flex justify-end mt-4">
                        {{ $resources->appends($_GET)->links() }}
                    </section>
                </header>

                <table class="table-auto w-full">
                    <thead>
                        <tr class="border-b border-gray-400">
                            <th class="text-left pb-2">
                                <a href="@route('resource-types.show', array_merge($_GET, 
                                        [
                                        $resourceType, 
                                        'reverse' => !Request::query('reverse'),
                                        'sortMeta' => false
                                        ]))">
                                        Resource Name
                                    </a>
                            </th>
                            
                            @foreach($enabledAttributes as $enabledAttributeHeader)
                                <th class="@if ($loop->last) text-right @else text-left @endif px-2 pb-2">
                                    <a href="@route('resource-types.show', array_merge($_GET, 
                                        [
                                        $resourceType, 
                                        'reverse' => !Request::query('reverse'),
                                        'sortMeta' => $enabledAttributeHeader->id
                                        ]))">
                                        {{ $resourceType->attributes->firstWhere('id', $enabledAttributeHeader->id)->name }}
                                    </a>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="">
                        @foreach ($resources as $resource) 
                            <tr class="w-full border-b border-gray-400 hover:bg-gray-300 hover:cursor-pointer
                                align-top 
                                @if ($loop->even) bg-gray-100 @endif
                            ">
                                <td class="py-2 pl-2 pt-2">
                                    <a href="{{ route('resources.edit', $resource) }}" class="text-blue-600 hover:underline">
                                        {{ $resource->name }}
                                    </a>
                                    
                                    <div>
                                        @foreach ($resource->getMedia() as $medium)
                                            @if (Str::contains($medium->mime_type, 'image'))
                                                <img class="w-16 inline-block" src="{{ $medium->getUrl('thumb') }}" />
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
                                        @endforeach
                                    </div>
                                </td>

                                @foreach ($enabledAttributes as $enabledAttribute)
                                    <td class="@if ($loop->last) text-right @else text-left @endif px-2 pt-2">
                                        @if ($resource->meta->where('resource_attribute_id', $enabledAttribute->id)->first()->value ?? false) 
                                            @foreach ($resource->meta->where('resource_attribute_id', $enabledAttribute->id) as $attribute)
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

                <footer class="mt-8">
                    {{ $resources->appends($_GET)->links() }}
                </footer>
            @else 
                <p class="text-xl">
                    No resources match your filters
                </p>
            @endif
        </section>
    @else 
        <h1 class="text-xl">
            No {{ $resourceType->name }} yet...  
        </h1>
    @endif
</section>

@endsection