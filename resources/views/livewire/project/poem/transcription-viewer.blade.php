<div class="border-b border-gray-200">
    <nav class="-mb-px space-x-4 mx-auto max-w-xs flex justify-center">
        @foreach ($medias as $medium)
            @if (Str::contains($medium->mime_type, 'image'))
                <button 
                    @if ($loop->index === 0)
                        id="first-media-button"
                    @endif
                    wire:click="setMedia({{ $medium->id }})"
                    class="w-12 hover:bg-indigo-100 border-b-2 border-transparent pb-2
                        @if ($media->id == $medium->id) border-indigo-500 @endif
                        hover:shadow-lg">
                        <img class="object-contain" src="{{ $medium->getUrl('thumb') }}" />
                </button>
            @endif
        @endforeach

        <script>
            setTimeout(function() {
                document.querySelector('#first-media-button').click();
            }, 600);
        </script>
    </nav>

    <main class="mt-4 flex flex-wrap">
        <div id="js-transcription-source" class="h-0 w-0 opacity-0">
            <!-- Manuscript Transcription -->
            {!! optional($poem->meta->firstWhere('resource_attribute_id', 78))->value !!}
        </div>

        <div id="js-transcription-display" class="w-full md:w-1/3 lg:w-1/2 text-2xl">
        </div>

        <div class="w-full md:w-2/3 lg:w-1/2 md:pl-4 lg:pl-8">
            <div wire:loading.remove>
                {{ $media }}
            </div>

            <div wire:loading.class.remove="hidden" class="justify-center flex hidden">
                <div wire:loading class="animate-ping h-12 w-12 text-gray-700 hover:text-gray-500 focus:outline-none 
                    focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 
                    transition ease-in-out duration-150">
                    <img class="object-contain h-screen" src="{{ asset('img/bird-icon-round.png') }}" />
                </div>
            </div>
        </div>
    </main>
</div>
