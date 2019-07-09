
@extends ('layouts.web')

@section('content')
    <header class="flex justify-end align-middle my-6 mx-2">
        <a href="{{ route('encodings.create') }}" 
            class="btn btn-blue mx-2">
            Add a new Encoding 
        </a>

        <a href="{{ route('resource-types.index') }}" 
            class="btn btn-hollow">
            See my resources
        </a>
    </header>

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
            Encodings -- Total: {{ $encodings->count() }}
        </h1>

        <section class="my-4 flex flex-wrap">
            @foreach ($encodings as $encoding)
                @include('encodings.item', ['encoding' => $encoding])
            @endforeach
        </section>
    </main> 
@endsection