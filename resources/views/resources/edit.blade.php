@extends ('layouts.resources.edit')

@section ('content')

<section class="flex flex-wrap mb-8">
    {{ html()->modelForm($resource, 'PUT', route('resources.update', $resource))->open() }}
        @include('resources.form')

        <footer class="py-4">
            <button class="btn btn-hollow">
                Save the changed name 
            </button>
        </footer>
    {{ html()->closeModelForm() }}
    
    @foreach ($resource->definition->mainAttributes as $attribute) 
        <article class="w-full my-4 mb-16">
            <h1 class="font-semibold"> 
                {{ $attribute->name }}
            </h1>

            @if ($field = $resource->mainMeta->firstWhere('key', $attribute->name))
                {{ html()->modelForm($field, 'PUT', route('resource.metas.update', ['resource' => $resource, 'meta' => $field, 'attribute' => true]))->open() }}
                    @if ($field->type == 'rich-text')
                        {{ html()->hidden('value')->attribute('id', $field->key) }}
                        <trix-editor input="{{ $field->key }}"></trix-editor>
                    @elseif ($field->type == 'encoding')
                        <h1 class="font-semibold">
                            Mock Encoding -- textbox is resizable as needed from bottom-right corner
                        </h1>

                        {{ html()->textarea('value')
                            ->class(['w-full', 'block', 'border', 'border-2', 'border-black'])
                            ->attribute('id', $field->key)
                        }}
                    @else  
                        @include('resource.attributes.field', ['attribute' => $field])
                    @endif

                    <button class="btn btn-blue">
                        Save changes to {{ $field->key }}
                    </button>
                {{ html()->closeModelForm() }}
            @else 
                {{ html()->modelForm($field, 'POST', route('resource.metas.store', ['resource' => $resource, 'attribute' => true]))->open() }}
                    {{ html()->hidden('key', $attribute->name) }}
                    @if ($attribute->type == 'rich-text')
                        {{ html()->hidden('value')->attribute('id', $field->key ?? null) }}
                        <trix-editor input="{{ $field->key }}"></trix-editor>
                    @elseif ($attribute->type == 'encoding')
                        <h1 class="font-semibold">
                            Mock Encoding -- textbox is resizable as needed from bottom-right corner
                        </h1>

                        {{ html()->textarea('value')
                            ->class(['w-full', 'block', 'border', 'border-2', 'border-black'])
                            ->attribute('id', $field->key ?? null)
                        }}
                    @else  
                        @include('resource.attributes.field', ['attribute' => $attribute])
                    @endif

                    <button class="btn btn-blue my-2">
                        Save changes to {{ $field->key ?? $attribute->name }}
                    </button>
                {{ html()->closeModelForm() }}
            @endif
        </article>
    @endforeach


</section>


@endsection