@extends ('layouts.web')

@section ('content')


<header class="flex align-left mb-8">
    <a href="{{ route('resource-types.index') }}" class="mx-2 font-bold underline">
        Resources
    </a>
</header>


<header class="flex justify-around my-6 mx-2">
    <a href="{{ route('resource-types.create') }}" 
        class="btn btn-blue">
        Add a new type of resource 
    </a>
</header>


<main class="my-2">
    <h1 class="font-semibold">
        Resource Types 
    </h1>

    <section class="my-4">
        @foreach ($resourceTypes as $resourceType)
            <div class="block">
                <article class="p-2">
                    <a href="{{ route('resource-types.show', $resourceType) }}">
                        {{ $resourceType->name }} -- {{ $resourceType->resources()->count() }}
                    </a>
                </article>
            </div>
        @endforeach
    </section>
</main> 

@endsection