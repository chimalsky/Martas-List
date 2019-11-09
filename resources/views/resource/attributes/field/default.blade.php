<div class="p-2 w-full md:w-1/2">
    <label class="bg-gray-200 block p-3 {{ $attribute->key }}">
        <span class="block">
            {{ $attribute->name }}
        </span>

        @foreach ($resource->meta->where('resource_attribute_id', $attribute->id) as $meta) 
            {{ html()->text("attribute[id-" . $meta->id . "]", $meta->value ?? null)
                ->class(['attribute', 'form-input', 'mt-1', 'block', 'w-full', 'font-medium']) }}
        @endforeach
       
        {{ html()->text("newAttribute[id-" . $attribute->id . "]")
            ->placeholder('Add Info!')
            ->class(['attribute', 'form-input', 'mt-1', 'block', 'w-full', 'font-medium']) }}
    </label>
</div>