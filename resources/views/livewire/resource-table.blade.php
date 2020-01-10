<div>
<section>
    @foreach ($resourceType->attributes as $attribute)
        <label class="block">
            <input type="checkbox" 
                name="attribute[{{ $attribute->id }}]" 
                
                /> 
                {{ $attribute->key }}
        </label>
    @endforeach

    <footer class="block mt-4">
        <button livewire:click="filter" class="btn btn-hollow">
            Filter
        </button>
    </footer>
</section>

<table class="table-auto w-full">
    <thead>
        <tr>
            <th class="text-left">
                Resource Name
            </th>
            
        </tr>
    </thead>
    <tbody class="">
        @foreach ($resources as $resource)
            <tr class="w-full border-b border-gray-400 hover:bg-gray-200 hover:cursor-pointer">
                <td class="py-2 pl-2">
                    <a href="{{ route('resources.edit', $resource) }}" class="text-blue-600">
                        {{ $resource->name }}
                    </a>
                </td>

            </tr>
        @endforeach 
    </tbody>
</table>

<div class="row">
    <div class="col">
        {{ $resources->links() }}
    </div>

    <div class="col text-right text-muted">
        Showing {{ $resources->firstItem() }} to {{ $resources->lastItem() }} out of {{ $resources->total() }} results
    </div>
</div>
</div>
