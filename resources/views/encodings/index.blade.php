
@extends ('layouts.web')

@section('content')
    <header class="flex justify-around my-6 mx-2">
        <h1 class="font-light">
            Marta's List 
        </h1>   

        <a href="{{ route('encodings.create') }}" 
            class="btn btn-blue">
            Add a new Encoding 
        </a>
    </header>


    <main class="my-2">
        <h1 class="font-semibold">
            Encodings -- Total: {{ $encodings->count() }}
        </h1>

        <section class="my-4 flex flex-wrap">
            @foreach ($encodings as $encoding)
                <div class="w-1/3 p-4">
                    <article class="bg-green-200 p-4">
                        <a href="{{ route('encodings.edit', $encoding) }}">
                            {{ $encoding->encoder_assigned_id }}
                        </a>

                        <p class="mt-4 text-right">
                            Created: {{ $encoding->created_at }}
                        </p>

                        <aside class="flex justify-end mt-2">
                            <a href="{{ route('encodings.edit', $encoding) }}"
                                class="btn btn-hollow">
                                Edit
                            </a>
                        </aside>
                    </article>
                </div>
            @endforeach
        </section>
    </main> 
@endsection