<div class="border-b border-gray-200" x-data="{
    transcriptionOn: new URLSearchParams(location.search).get('transcription'),
    transcriptionX: new URLSearchParams(location.search).get('x'),
    transcriptionY: new URLSearchParams(location.search).get('y'),
    activateTranscription: function() {
        const currentUrl = new URL(window.location.href)
        const searchParams = new URLSearchParams(currentUrl.search)
        searchParams.set('transcription', true)
        currentUrl.search = searchParams.toString()
        window.history.pushState({}, '', currentUrl.toString())
        this.transcriptionOn = true
    },
    deactivateTranscription: function() {
        const currentUrl = new URL(window.location.href)
        const searchParams = new URLSearchParams(currentUrl.search)
        searchParams.delete('transcription')
        currentUrl.search = searchParams.toString()
        window.history.pushState({}, '', currentUrl.toString())
        this.transcriptionOn = false
    },
    toggleTranscription: function() {
        this.transcriptionOn ? this.deactivateTranscription() : this.activateTranscription()
    }
}">
    <nav class="-mb-px space-x-4 flex justify-center">
        @if ($medias->count() > 1)
            @foreach ($medias as $index => $medium)
                @if (Str::contains($medium->mime_type, 'image'))
                    <button 
                        @if ($loop->index === 0)
                            id="first-media-button"
                        @endif
                        wire:click="setMedia({{ $medium->id }})"
                        class="w-4 hover:bg-indigo-100 border-b-2 border-transparent pb-1
                            @if ($media->id == $medium->id) border-indigo-500 @endif
                            hover:shadow-lg">
                            <img class="object-contain" src="{{ $medium->getUrl('thumb') }}" />
                    </button>
                @endif
            @endforeach
        @endif

        @if ($medias->count())
            <script>
                setTimeout(function() {
                    // Hacky way of activating the first manuscript as default
                    document.querySelector('#first-media-button').click()
                }, 600)
                setTimeout(function() {
                    // Hacky way of hiding fouc when transcription is on
                    document.querySelector('#js-transcription-display').classList.remove('invisible')
                }, 1000)
            </script>
        @endif

        <div class="flex items-center">
            <span class="italic">Transcription</span>
            <button @click="toggleTranscription" 
                type="button"
                :class="transcriptionOn ? 'bg-gray-600' : 'bg-gray-200'" 
                class="ml-2 relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" 
                role="switch" aria-checked="false">
                <span class="sr-only">Toggle Transcription</span>
                <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
                <span aria-hidden="true" :class="transcriptionOn ? 'translate-x-5' : 'translate-x-0'"
                    class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
            </button>
        </div>
    </nav>


    <main class="mt-1 flex flex-wrap">
        <div class="w-full relative">
            @if($placeholderMeta = $poem->meta()->firstWhere('resource_attribute_id', 149))
                <section class="mb-4 italic">
                    @if ($placeholderMeta->value == 'placeholder for LOST or DESTROYED MS')
                        <div class="flex justify-center mt-12">
                            <img class="w-20 h-20" src="/img/lost-or-destroyed.png" />
                        </div>
                        
                        <p class="text-center">
                            Original manuscript lost or destroyed
                        </p>
                    @elseif ($placeholderMeta->value == 'placeholder for MS we need to request digital image for')
                        <div class="flex justify-center">
                            <img class="w-16 h-16 align-center mt-12" src="/img/coming-soon.jpg" />
                        </div>
                        
                        <p class="text-center mt-12">
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

            <div x-show="transcriptionOn"
                id="js-transcription-display" class="absolute min-w-lg p-12 mx-auto w-96"
                style="font-family: Alegreya; font-weight: 500; background: #f8f3e8; opacity: .72; top:0;
                    clip-path: polygon(0 0, 0 100%, 100% 100%, 100% 33%, 72% 0);">
                <img id="transcription-icon" src="{{ asset('img/bird-icon.png') }}" class="h-10 w-10 mb-4 mx-auto mt-4 hover:cursor-pointer" />
                <div>{!! $this->activePage !!}</div>
            </div>

            <script>
                const transcriptionIcon = document.querySelector('#transcription-icon');
                transcriptionIcon.addEventListener("mouseover", function() {
                    transcriptionIcon.src = "{{ asset('img/bird-icon-hover.png') }}";
                });

                transcriptionIcon.addEventListener("mouseout", function() {
                    transcriptionIcon.src = "{{ asset('img/bird-icon.png') }}";
                });
            </script>
        </div>
    </main>
</div>
