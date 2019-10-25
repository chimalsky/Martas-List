<section class="flex flex-wrap">
    @foreach ($attributes as $attribute)
        <div class="w-1/2 p-2">
            <div class="p-4 bg-gray-300">
                <label>
                    <span class="block">
                        {{ $attribute->name }}
                    </span>
                    @include('resource.attributes.fields', ['attribute' => $attribute])
                </label>
            </div>
        </div>
    @endforeach
</section>
