@extends ('layouts.project')


@section ('header')
    @include('project._nav', ['title' => 'Poem Archive'])
@endsection

@section ('content')
<main class="max-w-2xl mx-auto text-gray-700 text-lg">

    <section class="mt-12 flex flex-col">

        @foreach ($poems as $poem)
            <article class="block mb-1 p-2 cursor-pointer justify-between">
                <a href="@route('project.poems.show', $poem->id)">
                    @foreach ($poem->getMedia() as $medium)
                        @if (Str::contains($medium->mime_type, 'image'))
                            <img class="w-12 inline-block" src="{{ $medium->getUrl('thumb') }}" />
                        @endif
                    @endforeach

                    {{ $poem->meta->where('resource_attribute_id', 84)->first()->value ?? null }}
                </a>
            </article> 
        @endforeach
    </section>
</main>

@endsection