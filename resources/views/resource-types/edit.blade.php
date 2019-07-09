@extends ('layouts.web')

@section ('content')

<header class="flex justify-between mb-8">
    <a class="btn btn-gray" href="{{ route('resource-types.index') }}">
        Return to my list of resources
    </a>
    
</header>



<section class="flex flex-wrap mb-8">
    {{ html()->modelForm($resourceType, 'PUT', route('resource-types.update', $resourceType))->open() }}
        @include('resource-types.form')

        <footer class="py-4">
            <button class="btn btn-hollow">
                Save changes to this Resource Type 
            </button>
        </footer>
    {{ html()->closeModelForm() }}
</section>


<section class="border border-1 border-red-900 p-4 mb-4">
    <h1 class="text-xl">
        Add a new {{ $resourceType->nameSingular }} 
    </h1>

    {{ html()->form('POST', route('resources.store'))->open() }}
        @include('resources.form', ['resourceType' => $resourceType])
        
        <button class="btn btn-blue my-2">
            Add a new {{ $resourceType->name }} resource
        </button>
    {{ html()->form()->close() }}
</section>

@isset($resourceType->resources)
    <h1 class="text-xl">
        {{ $resourceType->name }} resources: 
    </h1>

    <section class="flex flex-wrap my-2">
        @foreach($resourceType->resources as $resource)
            @include('resources.item', ['resource' => $resource])
        @endforeach 
    </section>
@endisset

@endsection