@extends ('layouts.resources.edit')

@section ('content')
    <section class="flex flex-wrap mb-8 bg-gray-200 p-4">
        <h1 class='text-xl text-gray-500'>
            Add a new Temporality 
        </h1>

        <div class="w-full p-4">
            {{ html()->form('POST', route('resource.temporalities.store', $resource))->open() }}

                @include('resource.temporalities.form')

                <footer class="py-4">
                    <button class="btn btn-hollow">
                        Add temporality to {{ $resource->name }} 
                    </button>
                </footer>
            {{ html()->form()->close() }}
        </div>
    </section>

    <section class="flex flex-wrap">
        <h1 class="w-full my-4">
            {{ $resource->name }} temporalities 
        </h1>

        @foreach ($resource->temporalities as $temporality)
            <article class="w-1/2 p-2">
                <h1 class="font-bold">
                    {{ $temporality->name }}
                </h1>

                <section class="">
                    Begins around {{ $temporality->startEnglish }} 
                </section>
                
                <section>
                    Ends around {{ $temporality->endEnglish }}
                </section>

                <footer class="flex justify-center mt-4">
                    {{ html()->form('DELETE', route('resource.temporalities.destroy', [
                        'resource' => $resource,
                        'temporality' => $temporality
                        ])
                        )->open()
                    }}

                        <button class="btn btn-red text-xs">
                            Delete 
                        </button>

                    {{ html()->form()->close() }}
                </footer>
            </article>
        @endforeach
    </section>
@endsection