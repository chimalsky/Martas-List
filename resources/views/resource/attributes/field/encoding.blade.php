<div id="{{ $attribute->id }}" class="w-full my-4">
        <h1 class="font-semibold mb-2">
            Mock Encoding -- textbox is resizable as needed from bottom-right corner
        </h1>

        @if ($resource->meta()->where('resource_attribute_id', $attribute->id)->exists()) 
            {{ html()->textarea("attribute[id-" . $resource->meta->firstWhere('resource_attribute_id', $attribute->id)->id  . "]", 
                $resource->meta->firstWhere('resource_attribute_id', $attribute->id)->value)
                ->class(['w-full', 'block', 'border', 'bg-transparent', 'border-2', 'border-white'])
                ->attribute('id', $attribute->key)
            }}
        @else
            {{ html()->textarea("newAttribute[id-" . $attribute->id . "]", 
                null)
                ->class(['w-full', 'block', 'border', 'bg-transparent', 'border-2', 'border-white'])
                ->attribute('id', $attribute->key)
            }}
        @endif
</div>