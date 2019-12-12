<div class="p-2 w-full md:w-1/2">
    <main class="p-2 bg-gray-200">
        <label class="block p-3 {{ $attribute->key }}">
            <span class="block text-xl mb-4">
                {{ $attribute->name }} 
            </span>

            @foreach ($resource->meta->where('resource_attribute_id', $attribute->id) as $meta)
                <section class="mb-6" data-controller="resource-meta">
                    {{ html()->select("attribute[id-" . $meta->id . "]", $attribute->optionsDropdown, $meta->value ?? null)
                        ->class(['attribute', 'form-dropdown', 'mt-1', 'block', 'w-full', 'font-medium']) }}

                    @livewire('resource-attribute', $meta->id)
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
        </section>
    </footer>
</div>