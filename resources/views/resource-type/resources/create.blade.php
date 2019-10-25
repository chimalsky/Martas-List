@extends ('layouts.web')

@section ('content')

<header class="flex align-left mb-8">
    <a href="{{ route('resource-types.index') }}">
        Resources
    </a>

    <span class="mx-4">
        >
    </span>

    <a href="{{ route('resource-types.show', $resourceType) }}" class="mx-2">
        {{ $resourceType->name }} 
    </a>

    <span class="mx-4">
        >
    </span>

    <p class="mx-2 font-bold underline">
       Adding New {{ $resourceType->nameSingular }}
    </p>
</header>


<section class="mb-8 max-w-4xl">
   
    {{ html()->form('POST', route('resource-type.resources.store', $resourceType))->open() }}
        @include('resource.form', ['resourceType' => $resourceType])
        
        <button class="btn btn-blue my-2">
            Add a new {{ $resourceType->nameSingular }} resource
        </button>
    {{ html()->form()->close() }}
</section>

@endsection