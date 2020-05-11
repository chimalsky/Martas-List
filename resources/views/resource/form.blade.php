

{{ html()->hidden('resource_type_id', $resource->definition->id ?? $resourceType->id) }}

<label class="w-full px-2">
    @if (isset($resource))
        @if ( $resource->meta()->where('resource_attribute_id', 77)->exists() )
            <img src="{{ $resource->meta->firstWhere('resource_attribute_id', 77)->value }}" 
                class="object-none mb-2" />
        @endif
    
        @if ( $resource->meta()->where('resource_attribute_id', 75)->exists() )
            <audio controls class="my-2"
                src="{{ $resource->meta->firstWhere('resource_attribute_id', 75)->value }}/download">
                    Your browser does not support the
                    <code>audio</code> element.
            </audio>
        @endif
    @endif

    <span class="">
        What should we name this {{ $resource->definition->nameSingular ?? $resourceType->nameSingular }}?
    </span>

    {{ html()->text('name')->class(['form-input', 'mt-1', 'block', 'w-full']) }}
</label>

<section class="mt-2 mb-4 px-2">
    <label class="">
        Citation: 
        {{ html()->text('citation', $resource->citation->citation ?? null)
            ->class(['form-input', 'mt-1', 'block', 'w-full']) }}
    </label>
</section>

<section class="attributes flex flex-wrap">
   
    @foreach ($resource->definition->attributes as $attribute)
        @if ($attribute->type == 'rich-text' || $attribute->type == 'encoding')
            @include('resource.attributes.field.'.$attribute->type, ['attribute' => $attribute])
        @else
            @include('resource.attributes.partials._base', ['attribute' => $attribute])
        @endif
    @endforeach

</section>

<section class="sonogram">
    @unless (isset($resource))
        <img src="" class="sonogram"/>
    @endunless
</section>

@if ($resource->definition->id == 6)
    <button class="btn btn-blue hidden block mb-8" onclick="xenoPower()" type="button">
        Xeno Power! 
    </button>
@endif
