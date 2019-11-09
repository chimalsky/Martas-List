<div class="w-full my-4">
    <span class="block">
        {{ $attribute->name }}
    </span>
        
    @if ($resource->meta()->where('resource_attribute_id', $attribute->id)->exists()) 
        {{ html()->hidden("attribute[id-" . $resource->meta->firstWhere('resource_attribute_id', $attribute->id)->id . "]", 
            $resource->meta->where('resource_attribute_id', $attribute->id)->first()->value)
            ->attribute('id', $attribute->key) }}
        <trix-editor input="{{ $attribute->key }}"></trix-editor>
    @else
        {{ html()->hidden("newAttribute[id-" . $attribute->id . "]", 
            null)
            ->attribute('id', $attribute->key) }}
        <trix-editor input="{{ $attribute->key }}"></trix-editor>
    @endif

</div>

