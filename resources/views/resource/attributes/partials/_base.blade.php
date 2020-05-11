<div id="{{ $attribute->id }}" class="p-2 w-full md:w-1/2 mb-16">
    <main class="p-2">
        <div class="block {{ $attribute->key }}">
            <span class="block text-2xl font-hairline mb-2">
                {{ $attribute->name }}
            </span>
            
            <section class="pl-6 pr-4">
                @foreach ($resource->metaByAttribute($attribute) as $meta)
                    @include('resource.attributes.field._base', ['meta' => $meta])
                @endforeach
            </section>
        </div>
    </main>
    
    <footer class="p-2" data-controller="resource-meta">

        @routeIs('resources.edit')
            <div class="flex justify-center">
                <button class="mb-3 text-xs underline" data-action="resource-meta#addNewAttribute">
                    @if ($resource->metaByAttribute($attribute)->count())
                        Add another {{ $attribute->name }}
                    @else 
                        Add {{ $attribute->name }} 
                    @endif
                </button>
            </div>
        @endrouteIs

        <section data-target="resource-meta.newAttribute" 
            @routeIs('resources.edit')
                class="hidden"
            @endrouteIs>

            @includeIf('resource.attributes.partials._'.$attribute->type)
        </section>
    </footer>

</div>