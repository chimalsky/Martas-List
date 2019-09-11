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

            {{ html()->hidden('key', $attribute->key) }}

            @if ($field = $resource->mainMeta->firstWhere('key', $attribute->name))
                {{ html()->modelForm($field, 'PUT', route('resource.metas.update', ['resource' => $resource, 'meta' => $field, 'attribute' => true]))->open() }}
                    @include('resource.attributes.fields', ['attribute' => $field])
            @else 
                {{ html()->modelForm($field, 'POST', route('resource.metas.store', ['resource' => $resource, 'attribute' => true]))->open() }}
                    @include('resource.attributes.fields', ['attribute' => $attribute])
            @endif
                <button class="btn btn-blue my-2">
                    Save changes to {{ $attribute->name }}
                </button>
            {{ html()->closeModelForm() }}
        </article>
    @endforeach
</section>


@endsection