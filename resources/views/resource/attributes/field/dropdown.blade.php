<div class="p-2 w-full md:w-1/2">
    <main class="p-2 bg-gray-200">
        <div class="block p-3 {{ $attribute->key }}">
            <span class="block text-xl mb-4">
                {{ $attribute->name }} 
            </span>

            @foreach ($resource->metaByAttribute($attribute) as $meta)
                <div x-data="{ open: false }" data-meta-id="{{ $meta->id }}"
                    class="block mb-4 pb-2 flex align-top">
                    <section class="flex-auto" data-controller="resource-meta">
                        {{ html()->select("attribute[id-" . $meta->id . "]", $attribute->optionsDropdown, $meta->value ?? null)
                            ->class(['attribute', 'form-dropdown', 'mt-1', 'block', 'w-full', 'font-medium']) }}

                    </section>


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
            @endforeach
        </div>
    </main>
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
            {{ html()->select("newAttribute[id-" . $attribute->id . "]", $attribute->optionsDropdown)
                ->placeholder('Add Info!')
                ->class(['attribute', 'form-dropdown', 'mt-1', 'block', 'w-full', 'font-medium']) }}
        </section>
    </footer>
</div>