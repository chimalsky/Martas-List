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

    @foreach ($resource->mainMeta as $field)
        <article class="w-full my-4 mb-16">
            <h1 class="font-semibold"> 
                {{ $field->key }}
            </h1>

            {{ html()->modelForm($field, 'PUT', route('resource.metas.update', ['resource' => $resource, 'meta' => $field]))->open() }}
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
                @endif

                <button class="btn btn-blue">
                    Save changes to {{ $field->key }}
                </button>
            {{ html()->closeModelForm() }}
        </article>
    @endforeach



</section>


@endsection