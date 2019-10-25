@extends ('layouts.resources.edit')

@section ('content')

<section class="flex flex-wrap mb-8">
    {{ html()->modelForm($resource, 'PUT', route('resource-type.resources.update', [
        'resource-type' => $resource->definition,
        'resource' => $resource
        ]))->open() }}

        @include('resource.form')

        <footer class="py-4">
            <button class="btn btn-hollow">
                Save changes
            </button>
        </footer>
    {{ html()->closeModelForm() }}
    
</section>


@endsection