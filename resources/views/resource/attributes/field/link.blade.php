<div class="p-2 w-full md:w-1/2">
    <div class="bg-gray-200 block p-3 {{ $attribute->key }}">
        <span class="block text-xl mb-2">
            {{ $attribute->name }}
        </span>

        @foreach ($resource->metaByAttribute($attribute) as $meta)
            <article data-meta-id="{{ $meta->id }}">
                <div x-data="{ open: false }" class="block pb-2 flex align-top">
                        {{ html()->text("attribute[id-" . $meta->id . "]", $meta->value ?? null)
                            ->attribute('data-target', 'link')
                            ->class(['attribute', 'form-input', 'mt-1', 'flex-auto', 'font-medium']) }}

                    <aside class="flex-none ml-2 relative">
                        <button type="button" class="border-2 border-gray-500 p-2 relative"
                            @click="open = !open">
                            ---
                        </button>

                        <section x-show="open" @click.away="open = false" class="absolute right-0 p-4 bg-indigo-100">
                            @livewire('resource-attribute', $meta->id)
                        </section>
                    </aside>
                </div>
                @if ($meta->value)
                    <a href="{{ $meta->value }}"
                        class="block mb-2">
                    
                        {{ $meta->value }}
                    </a>
                @endif
            </article>
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