<div class="p-2 w-full md:w-1/2">
    <main class="p-2 bg-gray-200">
        <label class="block p-3 {{ $attribute->key }}">
            <span class="block">
                {{ $attribute->name }}
            </span>

            @foreach ($resource->meta->where('resource_attribute_id', $attribute->id) as $meta)
                <section class="mb-6">
                    {{ html()->text("attribute[id-" . $meta->id . "]", $meta->value ?? null)
                        ->class(['attribute', 'form-input', 'mt-1', 'block', 'w-full', 'font-medium']) }}
                    
                    {{ html()->text("attributeCitation[id-" . $meta->id . "]", $meta->citation->citation ?? null)
                        ->placeholder('citation')
                        ->class(['citation', 'form-input', 'font-mono', 'border', 'border-black', 'mt-1',
                            'bg-indigo-100', 'ml-4', 'block', 'w-11/12', 'font-medium']) }}
                </section>
            @endforeach
        </label>
    </main>
    <footer class="p-2 bg-indigo-200">
        {{ html()->text("newAttribute[id-" . $attribute->id . "]")
            ->placeholder('Add Info!')
            ->class(['attribute', 'form-input', 'mt-1', 'block', 'w-full', 'font-medium']) }}

        {{ html()->text("newAttributeCitation[id-" . $attribute->id . "]")
            ->placeholder('citation')
            ->class(['citation', 'form-input', 'font-mono', 'border', 'border-black', 'mt-1',
                'bg-indigo-100', 'ml-4', 'block', 'w-11/12', 'font-medium']) }}
    </footer>
</div>