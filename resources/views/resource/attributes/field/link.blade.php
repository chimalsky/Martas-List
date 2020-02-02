<div class="p-2 w-full md:w-1/2">
    <div class="bg-gray-200 block p-3 {{ $attribute->key }}">
        <span class="block text-xl mb-2">
            {{ $attribute->name }}
        </span>

        @foreach ($resource->metaByAttribute($attribute) as $meta)
            @include('resource.attributes.field._base', ['meta' => $meta])
        @endforeach
        
        <footer class="p-2 bg-indigo-200" data-controller="resource-meta">
            @routeIs('resources.edit')
                <button class="mb-3" data-action="resource-meta#addNewAttribute">
                    @if ($resource->metaByAttribute($attribute)->count())
                        Add additional attribute
                    @else 
                        Add info 
                    @endif
                </button>
            @endrouteIs 

            <section data-target="resource-meta.newAttribute" 
                @routeIs('resources.edit')
                    class="hidden"
                @endrouteIs>
                {{ html()->text("newAttribute[id-" . $attribute->id . "]")
                    ->placeholder('Add info!')
                    ->attribute('data-target', 'link')
                    ->class(['attribute', 'form-input', 'mt-4', 'block', 'w-full', 'font-medium']) }}
            </section>
        </footer>

    </div>
</div>