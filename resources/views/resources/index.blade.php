@extends ('layouts.web')

@section('content')
<h1>
    View by Resource Type
</h1>

<ul class="flex flex-wrap align-start">
    @foreach(\App\ResourceType::all() as $resourceType)
        <li class="py-2 px-4">
            <a href="{{ route('resources.index', ['type' => $resourceType]) }}">
                {{ $resourceType->name }}
            </a>
        </li>
    @endforeach
</ul>


<main class="my-2">
    <h1 class="font-semibold">
        {{ $type->name }} -- Total: {{ $resources->count() }}
    </h1>

    <section class="my-4 flex flex-wrap">
        @foreach ( $resources as $resource )
            @include('resources.item', ['resource' => $resource])
        @endforeach
    </section>
</main> 


@endsection


