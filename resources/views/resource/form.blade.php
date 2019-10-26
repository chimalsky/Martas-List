

{{ html()->hidden('resource_type_id', $resource->definition->id ?? $resourceType->id) }}

<label class="w-full px-2 max-w-md">
    <span class="text-gray-700">
        What should we name this {{ $resource->definition->nameSingular ?? $resourceType->nameSingular }}?
    </span>

    {{ html()->text('name')->class(['form-input', 'mt-1', 'block', 'w-full']) }}
</label>

@include('resource-type.attributes.form', 
    [
        'attributes' => $resourceType->mainAttributes ?? $resource->definition->mainAttributes,
        'resource' => $resource ?? null
    ]
)
