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


    @if (strtolower($resource->definition->name) == 'poems')
        
        <h1 class="w-full">
            The Magical Bobolink has hidden the encodings/mock-encodings editing portion for now. He will let 
            you know when it is back online. Do not worry, all the encodings you've produced before are safe 
            in the magical nest.
        </h1>

    @endif



</section>


@endsection