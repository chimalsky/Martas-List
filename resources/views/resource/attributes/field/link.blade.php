<div class="p-2 w-full md:w-1/2">
    <label class="bg-gray-200 block p-3">
        <span class="block">
            {{ $attribute->name }}
        </span>
        
        {{ html()->text("attribute[" . $attribute->name . "]", $resource->mainMeta->firstWhere('key', $attribute->key)->value ?? null)
            ->attribute('data-target', 'link')
            ->class(['attribute', 'form-input', 'mt-1', 'block', 'w-full', 'font-medium']) }}
        
        @if ($resource->mainMeta->firstWhere('key', $attribute->key))
            <a href="{{ $resource->mainMeta->firstWhere('key', $attribute->key)->value }}"
                class="text-right">
            
                {{ $resource->mainMeta->firstWhere('key', $attribute->key)->value }}
            </a>
        @endif
    </label>
</div>