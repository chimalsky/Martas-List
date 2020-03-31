<div id="{{ $attribute->id }}" class="w-full my-4">
        <h1 class="font-semibold">
            Mock Encoding -- textbox is resizable as needed from bottom-right corner
        </h1>

        @if ($resource->meta()->where('resource_attribute_id', $attribute->id)->exists()) 
            {{ html()->textarea("attribute[id-" . $resource->meta->firstWhere('resource_attribute_id', $attribute->id)->id  . "]", 
                $resource->meta->firstWhere('resource_attribute_id', $attribute->id)->value)
                ->class(['w-full', 'block', 'border', 'border-2', 'border-black'])
                ->attribute('id', $attribute->key)
            }}
        @else
            {{ html()->textarea("newAttribute[id-" . $attribute->id . "]", 
                null)
                ->class(['w-full', 'block', 'border', 'border-2', 'border-black'])
                ->attribute('id', $attribute->key)
            }}
        @endif
</div>