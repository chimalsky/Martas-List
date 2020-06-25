<div>
    
{{ html()->hidden('resource_type_id', $resource->definition->id) }}

<label class="block my-2">
    What should we name this {{ $resource->definition->nameSingular }}?

    <input class="form-input mt-1 block w-full" wire:model.debounce.400ms="name" />
    @error('name') <span class="error">{{ $message }}</span> @enderror
</label>


<label class="block my-4">
    <select class="form-input form-dropdown" wire:model="resource_category_id">
        <option value="" >
            --- Select a Category
        </option>   
        @foreach($resource->definition->categories as $category)
            <option value="{{ $category->id }}"> 
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</label>

<header class="block">
    @if ( $resource->meta()->where('resource_attribute_id', 77)->exists() )
        <img src="{{ $resource->meta->firstWhere('resource_attribute_id', 77)->value }}" 
            class="object-none mb-2" />
    @endif

    @if ( $resource->meta()->where('resource_attribute_id', 75)->exists() )
        <audio controls class="my-2"
            src="{{ $resource->meta->firstWhere('resource_attribute_id', 75)->value }}/download">
                Your browser does not support the
                <code>audio</code> element.
        </audio>
    @endif
</header>

<section class="mt-2 mb-4">
    <label class="">
        Citation: 

        <input wire:model.debounce.500ms="citation" class="form-input block w-full"/>
        
    </label>
</section>

</div>
