

{{ html()->hidden('resource_type_id', $resource->definition->id ?? $resourceType->id) }}

<label class="w-full px-2 max-w-md">
    @if (isset($resource))
        <img src="{{ $resource->mainMeta->firstWhere('key', 'sonogram') ?  $resource->mainMeta->firstWhere('key', 'sonogram')->value : null }}" 
            class="object-none mb-2" />
    
        @if ( isset($resource->mainMeta->firstWhere('key', 'source_link')->value) )
            <audio controls class="my-2"
                src="{{ $resource->mainMeta->firstWhere('key', 'source_link')->value }}/download">
                    Your browser does not support the
                    <code>audio</code> element.
            </audio>
        @endif
    @endif

    <span class="text-gray-700">
        What should we name this {{ $resource->definition->nameSingular ?? $resourceType->nameSingular }}?
    </span>

    {{ html()->text('name')->class(['form-input', 'mt-1', 'block', 'w-full']) }}
</label>

<section class="attributes">
    @include('resource-type.attributes.form', 
        [
            'attributes' => $resourceType->attributes ?? $resource->definition->attributes,
            'resource' => $resource ?? null
        ]
    )
</section>

<section class="sonogram">
    @unless (isset($resource))
        <img src="" class="sonogram"/>
    @endunless
</section>

@if ($resource->definition->id == 6)
    <button class="btn btn-blue block mb-8" onclick="xenoPower()" type="button">
        Xeno Power! 
    </button>
@endif
