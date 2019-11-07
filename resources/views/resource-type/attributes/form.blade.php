<section class="flex flex-wrap">
    @foreach ($attributes as $attribute)
        @if ($attribute->type)
            @includeIf('resource.attributes.field.' . $attribute->type, ['attribute' => $attribute])
        @else 
            @include('resource.attributes.field.default', ['attribute' => $attribute])
        @endif
    @endforeach
</section>
