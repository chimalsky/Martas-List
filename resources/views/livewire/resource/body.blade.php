<div>
    
<section class="attributes flex flex-wrap">
    @foreach ($attributes as $attribute)
        @unless(false)
            @switch ($attribute->type)
                @case('default') 
                    <x-resource.attribute.field :resource="$resource" :attribute="$attribute" 
                        :metas="$metas->where('resource_attribute_id', $attribute->id)" />
                    @break
                @case('dropdown')
                    <x-resource.attribute.dropdown :resource="$resource" :attribute="$attribute" />
                    @break
            @endswitch 
        @endunless

        @if ($attribute->type == 'rich-text' || $attribute->type == 'encoding')
            @include('resource.attributes.field.'.$attribute->type, ['attribute' => $attribute])
        @else
            @include('resource.attributes.partials._base', ['attribute' => $attribute])
        @endif
    @endforeach
</section>

</div>
