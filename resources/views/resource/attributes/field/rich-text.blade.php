<div class="w-full my-4">
    <span class="block">
        {{ $attribute->name }}
    </span>

    {{ html()->hidden("attribute[" . $attribute->key . "]", $resource->mainMeta->firstWhere('key', $attribute->key)->value ?? null)->attribute('id', $attribute->key) }}
    <trix-editor input="{{ $attribute->key }}"></trix-editor>
</div>