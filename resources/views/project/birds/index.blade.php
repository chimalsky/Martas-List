@extends ('layouts.project')


@section ('header')
    @include('project._nav', ['title' => 'Bird Archive'])
@endsection

@section ('content')
<main class="container mx-auto text-gray-700 text-lg">

    <section class="mt-12 flex flex-wrap">
        @foreach ($birds as $bird)
            <article class="w-full md:w-1/2 lg:w-1/3 mb-1 p-3 justify-between">
                <a href="@route('project.birds.show', $bird)" 
                class="block text-2xl text-gray-500 hover:underline">
                    {{ $bird->name }}
                </a>

                @foreach ($bird->getMedia() as $sonogram)
                    @if (Str::contains($sonogram->mime_type, 'image'))
                        <img class="block mt-2 mb-6" src="{{ $sonogram->getUrl('thumb') }}" />
                    @endif
                @endforeach 

                @foreach ($bird->getMedia() as $audio)
                    @if (Str::contains($audio->mime_type, 'audio'))
                        <audio controls
                            src="{{ $audio->getUrl() }}">
                                Your browser does not support the
                                <code>audio</code> element.
                        </audio>                    
                    @endif
                @endforeach
            </article> 
        @endforeach
    </section>
</main>

@endsection