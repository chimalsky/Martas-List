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

    <section class="my-4 flex flex-wrap">
        @foreach ($resourceTypes as $resourceType)
            <div class="w-1/3 p-4">
                <article class="border border-1 border-gray-600 p-4">
                    <a href="{{ route('resource-types.show', $resourceType) }}">
                        {{ $resourceType->name }}
                    </a>

                    <p class="mt-4 text-right">
                        Created: {{ $resourceType->created_at }}
                    </p>

                    <aside class="flex justify-end mt-2">
                        <a href="{{ route('resource-types.edit', $resourceType) }}"
                            class="btn btn-hollow hidden">
                            Edit
                        </a>
                    </aside>
                </article>
            </div>
        @endforeach
    </section>
</main> 

@endsection