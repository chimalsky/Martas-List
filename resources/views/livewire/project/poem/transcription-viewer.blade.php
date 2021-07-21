<div class="border-b border-gray-200">
    <nav class="-mb-px space-x-4 mx-auto max-w-xs flex justify-center">
        @foreach ($medias as $index => $medium)
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
                        {{ $index + 1}}
                </button>
            @endif
        @endforeach

        @if ($medias->count())
            <script>
                setTimeout(function() {
                    document.querySelector('#first-media-button').click();
                }, 600);
            </script>
        @endif
    </nav>

    <main class="mt-4 flex flex-wrap">
        <div id="js-transcription-display" class="w-full md:w-1/3 lg:w-1/2 text-2xl md:pl-10 italic" style="font-family: Alegreya; font-weight: 500;">
            {!! $this->activePage !!}
        </div>

        <div class="w-full md:w-2/3 lg:w-1/2 md:pl-4">
            @if($placeholderMeta = $poem->meta()->firstWhere('resource_attribute_id', 149))
                <section class="mb-4 italic">
                    @if ($placeholderMeta->value == 'placeholder for LOST or DESTROYED MS')
                        <div class="flex justify-center">
                            <img class="w-20 h-20" src="/img/lost-or-destroyed.png" />
                        </div>
                        
                        <p class="text-center">
                            Original manuscript lost or destroyed
                        </p>
                    @elseif ($placeholderMeta->value == 'placeholder for MS we need to request digital image for')
                        <div class="flex justify-center">
                            <img class="w-16 h-16 align-center" src="/img/coming-soon.jpg" />
                        </div>
                        
                        <p class="text-center">
                            Manuscript facsimile coming soon
                        </p>
                    @endif
                </section>
            @endif
            @if ($medias->count())
                <div wire:loading.remove class="max-h-screen">
                    <img class="max-h-full" src="{{ $media->getUrl() }}" />
                </div>

                <div wire:loading.class.remove="hidden" class="justify-center flex hidden">
                    <div wire:loading class="animate-ping h-12 w-12 text-gray-700 hover:text-gray-500 focus:outline-none 
                        focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 
                        transition ease-in-out duration-150">
                        <img class="object-contain" src="{{ asset('img/bird-icon-round.png') }}" />
                    </div>
                </div>
            @endif
        </div>
    </main>
</div>
