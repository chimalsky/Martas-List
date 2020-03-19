@extends ('layouts.project')


@section ('header')
    @include('project._nav', ['title' => 'Bird Archive'])
@endsection

@section ('content')
<main class="container mx-auto text-gray-700 text-lg">

    <section class="mt-12 flex flex-wrap">
        @foreach ($birds as $bird)
            <article class="w-full md:w-1/2 lg:w-1/3 mb-1 p-2 hover:bg-gray-200 cursor-pointer justify-between">
                <a href="block">
                    {{ $bird->name }}
                </a>

                @foreach ($bird->getMedia() as $sonogram)
                    @if (Str::contains($sonogram->mime_type, 'image'))
                        <img class="block" src="{{ $sonogram->getUrl('thumb') }}" />
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