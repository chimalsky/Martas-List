<div>
    <h1 class="mb-2">
        Search for Resources to connect with 
    </h1>

    <input type="text" wire:model="query" class="form-input mb-8" id="query-input" />
    
    @if($externalResources && count($externalResources))
        <section class="mt-6 border border-gray-600 p-4">
            <header class="flex justify-end">
                <button wire:click="clearQuery" class="text-right">
                    Clear Search
                </button>
            </header>

            @foreach ($queryable as $resourceType)
                @if ($externalResources->where('resource_type_id', $resourceType->id)->count())
                    <h1 class="font-bold">
                        {{ $resourceType->name }}
                    </h1>

                    @foreach ($externalResources->where('resource_type_id', $resourceType->id) as $externalResource)
                        <article class="block mb-4">
                            <label class="cursor-pointer hover:bg-gray-200 hover:text-black p-2">
                                <input type="checkbox" 
                                    @if ($resource->connectedResourcesIds->contains($externalResource->id))
                                        checked 
                                    @endif
                                    wire:change="updateConnection( {{ $externalResource->id }} )"
                                    value="{{ $externalResource->id }}" /> 
                                {{ $externalResource->name }}
                            </label>
                        </article>
                    @endforeach
                @endif
            @endforeach
        </section>  
    @endif


    <section class="flex flex-wrap">
        <section class="w-full max-w-3xl">
            @foreach ($queryable as $resourceType)
                <header class="m-2 w-full flex justify-between">
                    <h1 class="text-xl font-bold">
                        {{ $resourceType->name }} Connections
                    </h1>
                </header>

                <table class="table-auto w-full mb-10">
                    <thead>
                        <tr>
                            <th>
                            </th>

                            <th>

                            </th>
                            
                        </tr>
                    </thead>
                    <tbody class="">
                        @foreach ($resource->resources as $connectedResource) 
                            @if ($connectedResource->definition->is($resourceType))

                                <tr class="hover:cursor-pointer">
                                    <td class="py-2 pl-2">
                                        <a href="{{ route('resources.edit', $connectedResource) }}" class="text-2xl underline">
                                            {{ $connectedResource->name }}
                                        </a>
                                    </td>

                                    <td class="pr-2">
                                        <div class="flex justify-end mr-4 mt-4">
                                            <button wire:click="updateConnection( {{ $connectedResource->id }} )"
                                                class="btn btn-red">
                                                Disconnect
                                            </button>
                                        </div>
                                    </td>

                                
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        </section>
    </section>
</div>
