<div class="p-2 w-full md:w-1/2">
    <label class="bg-gray-200 block p-3">
        <span class="block">
            {{ $attribute->name }}
        </span>
        
        {{ html()->text("attribute[" . $attribute->key . "]", $resource->meta->firstWhere('key', $attribute->key)->value ?? null)
            ->class(['attribute', 'form-input', 'mt-1', 'block', 'w-full', 'font-medium']) }}
    </label>
</div>