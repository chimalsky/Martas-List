@extends ('layouts.web')

@section ('content')



<header class="mt-4 mb-16 mx-2">
    <a href="{{ route('resource-types.create') }}" 
        class="btn btn-blue">
        Add a new Archive 
    </a>
</header>


<main class="my-2">
    <section class="my-4">
        @foreach ($resourceTypes as $resourceType)
            <div class="block">
                <article class="p-2">
                    <a href="{{ route('resource-types.show', $resourceType) }}">
                        {{ $resourceType->name }}

                        <span class="italic ml-2 mr-8">
                            {{ $resourceType->subtitle }}
                        </span>
                        
                         -- {{ $resourceType->resources()->count() }}
                    </a>
                </article>
            </div>
        @endforeach
    </section>
</main> 

@endsection