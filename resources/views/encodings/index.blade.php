
@extends ('layouts.web')

@section('content')
    <header class="flex justify-end align-middle my-6 mx-2">
        <h1 class="font-light mx-2">
            Marta's List 
        </h1>   

        <a href="{{ route('encodings.create') }}" 
            class="btn btn-blue mx-2">
            Add a new Encoding 
        </a>

        <a href="{{ route('resource-types.index') }}" 
            class="btn btn-hollow">
            See my resources
        </a>
    </header>


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