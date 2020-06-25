<div>
    
<section class="attributes flex flex-wrap">
    @foreach ($attributes as $attribute)
        @unless(true)
            @switch ($attribute->type)
                @case('default') 
                    <x-resource.attribute.field :attribute="$attribute" />
                    @break
                @case('dropdown')
                    <x-resource.attribute.dropdown :attribute="$attribute" />
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
