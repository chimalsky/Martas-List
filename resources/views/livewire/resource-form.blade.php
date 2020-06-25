<div class="">

{{ html()->hidden('resource_type_id', $resource->definition->id) }}

<label class="block my-2">
    <span class="">
        What should we name this {{ $resource->definition->nameSingular }}?
    </span>

    <input class="form-input mt-1 block w-full" name="name" value="{{ $resource->name }}" />
</label>


<label class="block my-4">
    <select class="form-input form-dropdown" name="resource_category_id">
        <option value="" @if (is_null($resource->category_id)) selected @endif >
            --- Select a Category
        </option>
        @foreach($resource->definition->categories as $category)
            <option value="{{ $category->id }}"
                @if($resource->category_id == $category->id)
                    selected 
                @endif
                > 
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</label>

<header class="block">
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
</header>

<section class="mt-2 mb-4">
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

</div>