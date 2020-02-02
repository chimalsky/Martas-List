<div>

{{ html()->hidden('resource_type_id', $resource->definition->id) }}

<label class="w-full px-2">
    <span class="text-gray-700">
        What should we name this {{ $resource->definition->nameSingular }}?
    </span>

    <input class="form-input mt-1 block w-full" name="name" value="{{ $resource->name }}" />
</label>

<section class="mt-2 mb-4 px-2">
    <label class="">
        Citation: 
        {{ html()->text('citation', $resource->citation->citation ?? null)
            ->class(['form-input', 'mt-1', 'block', 'w-full']) }}
    </label>
</section>

<section class="attributes">
    @include('resource-type.attributes.form', 
        [
            'attributes' => $resource->definition->attributes,
            'resource' => $resource
        ]
    )
</section>

</div>