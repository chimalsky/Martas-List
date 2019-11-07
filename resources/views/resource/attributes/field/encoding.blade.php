<div class="w-full my-4">
    <label>
        <h1 class="font-semibold">
            Mock Encoding -- textbox is resizable as needed from bottom-right corner
        </h1>

        {{ html()->textarea("attribute[" . $attribute->key . "]", $resource->mainMeta->firstWhere('key', $attribute->key)->value ?? null)
            ->class(['w-full', 'block', 'border', 'border-2', 'border-black'])
            ->attribute('id', $attribute->key)
        }}
    </label>
</div>