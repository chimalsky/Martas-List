<div class="p-2 w-full md:w-1/2">
    <main class="p-2 bg-gray-200">
        <label class="block p-3 {{ $attribute->key }}">
            <span class="block">
                {{ $attribute->name }} 
            </span>

            @foreach ($resource->meta->where('resource_attribute_id', $attribute->id) as $meta)
                <section class="mb-6" data-controller="resource-meta">
                    {{ html()->select("attribute[id-" . $meta->id . "]", $attribute->optionsDropdown, $meta->value ?? null)
                        ->class(['attribute', 'form-dropdown', 'mt-1', 'block', 'w-full', 'font-medium']) }}

                    <button class="mt-3" data-action="resource-meta#addCitation">
                        @unless ($meta->citation) 
                            Add Citation
                        @else
                            Citation 
                        @endunless
                    </button>
                    
                    {{ html()->text("attributeCitation[id-" . $meta->id . "]", $meta->citation->citation ?? null)
                        ->placeholder('citation')
                        ->attribute('data-target', 'resource-meta.citation')
                        ->class(['citation', 'form-input', 'font-mono', 'border', 'border-black', 'mt-1',
                            'bg-indigo-100', 'ml-4', 'block', 'w-11/12', 'font-medium', 'hidden']) }}
                </section>
            @endforeach
        </label>
    </main>
    <footer class="p-2 bg-indigo-200" data-controller="resource-meta">
        <button class="mb-3" data-action="resource-meta#addNewAttribute">
            Add additional attribute
        </button>

        <section data-target="resource-meta.newAttribute" class="hidden">
            {{ html()->select("newAttribute[id-" . $attribute->id . "]", $attribute->optionsDropdown)
                ->placeholder('Add Info!')
                ->class(['attribute', 'form-dropdown', 'mt-1', 'block', 'w-full', 'font-medium']) }}

            {{ html()->text("newAttributeCitation[id-" . $attribute->id . "]")
                ->placeholder('citation')
                ->class(['citation', 'form-input', 'font-mono', 'border', 'border-black', 'mt-1',
                    'bg-indigo-100', 'ml-4', 'block', 'w-11/12', 'font-medium']) }}
        </section>
    </footer>
</div>