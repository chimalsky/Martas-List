<div id="{{ $attribute->id }}" class="w-full my-4">
    <span class="block">
        {{ $attribute->name }}
    </span>

    <style>
        .trix-button-row {
            background-color: #fff;
            padding-top: 10px;
        }
    </style>
        
    @if ($resource->meta()->where('resource_attribute_id', $attribute->id)->exists()) 
        <input name="attribute[id-{{ $resource->meta->firstWhere('resource_attribute_id', $attribute->id)->id }}]"
            id="{{ $attribute->key }}"
            type="hidden"
            value="{{ $resource->meta->firstWhere('resource_attribute_id', $attribute->id)->value }}" />

        <trix-editor input="{{ $attribute->key }}"></trix-editor>
    @else
        {{ html()->hidden("newAttribute[id-" . $attribute->id . "]", 
            null)
            ->attribute('id', $attribute->key) }}
        <trix-editor input="{{ $attribute->key }}"></trix-editor>
    @endif

</div>

