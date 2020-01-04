<div class="p-2 w-full md:w-1/2">
    <main class="p-2 bg-gray-200">
        <div class="block p-3 {{ $attribute->key }}">
            <span class="block text-xl mb-2">
                {{ $attribute->name }}
            </span>
            
            @foreach ($resource->metaByAttribute($attribute) as $meta)
                <section class="mb-4 pb-2" data-controller="resource-meta">
                    {{ html()->text("attribute[id-" . $meta->id . "]", $meta->value ?? null)
                        ->class(['attribute', 'form-input', 'mt-1', 'block', 'w-full', 'font-medium']) }}

                    @livewire('resource-attribute', $meta->id)
                </section>
            @endforeach
        </div>
    </main>
    
    <footer class="p-2 bg-indigo-200" data-controller="resource-meta">

        <button class="mb-3" data-action="resource-meta#addNewAttribute">
            @if ($resource->metaByAttribute($attribute)->count())
                Add additional attribute
            @else 
                Add info 
            @endif
        </button>

        <section data-target="resource-meta.newAttribute" class="hidden">
            {{ html()->text("newAttribute[id-" . $attribute->id . "]")
                ->placeholder('Add Info!')
                ->class(['attribute', 'form-input', 'mt-1', 'block', 'w-full', 'font-medium']) }}
        </section>
    </footer>
</div>